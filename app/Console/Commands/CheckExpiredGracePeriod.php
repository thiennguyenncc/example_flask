<?php

namespace App\Console\Commands;

use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Services\ParticipantForRematchDomainService;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchService;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Models\Invoice;
use Bachelor\Domain\PaymentManagement\Invoice\Services\InvoiceService;
use Bachelor\Domain\PaymentManagement\Payment\Events\GracePeriodExpired;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CheckExpiredGracePeriod extends BachelorBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:grace_period_expired';

    protected  InvoiceRepositoryInterface $invoiceRepository;
    protected  UserDomainService $userDomainService;
    protected  UserRepositoryInterface $userRepository;
    protected  ParticipantMainMatchService $participantMainMatchService;
    protected  ParticipantForRematchDomainService $participantForRematchDomainService;
    protected  DatingDomainService $datingDomainService;
    protected  UserTrialService $userTrialService;
    protected  InvoiceService $invoiceService;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check expired grace period and Deactivate user who has expired grace period';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository,
        UserDomainService $userDomainService,
        UserRepositoryInterface $userRepository,
        ParticipantMainMatchService $participantMainMatchService,
        ParticipantForRematchDomainService $participantForRematchDomainService,
        DatingDomainService $datingDomainService,
        UserTrialService $userTrialService,
        InvoiceService $invoiceService
    ) {
        parent::__construct();
        $this->invoiceRepository = $invoiceRepository;
        $this->userDomainService = $userDomainService;
        $this->userRepository = $userRepository;
        $this->participantMainMatchService = $participantMainMatchService;
        $this->participantForRematchDomainService = $participantForRematchDomainService;
        $this->datingDomainService = $datingDomainService;
        $this->userTrialService = $userTrialService;
        $this->invoiceService = $invoiceService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $startTime = microtime(true);
        DB::beginTransaction();
        try {

            $this->_make();

            $time = microtime(true) - $startTime;
            $this->info("Deactivated user who has expired grace period Successfully | took $time ms");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $this->info($e->getMessage());
        }
    }

    private function _make()
    {
        $invoices = $this->invoiceRepository->getAllUnpaidInvoicesWhichGracePeriodExpired();
        $invoices->each(function (Invoice $invoice) {
            $user = $this->userRepository->getById($invoice->getUserPaymentCustomer()->getUserId());

            if ($user->getStatus() !== UserStatus::ApprovedUser) return;

            $result = $this->userDomainService->validateUserCanCancelDeactivateAccount($user, false);
            if ($result['need_cancel_participant']) {
                $this->participantMainMatchService->cancelAllAwaitingForUser($user);
            }
            if ($result['need_cancel_participant_for_rematch']) {
                $this->participantForRematchDomainService->cancelAllAwaitingForUser($user);
            }
            if ($result['need_cancel_incompleted_dating']) {
                $datings = $this->datingDomainService->cancelAllIncompletedDatingForUser($user);
                $datings->each(function (Dating $dating) use ($user) {
                    $this->invoiceService->createCancellationFeeInvoice(
                        $user->getUserPaymentCustomer(),
                        Carbon::parse($dating->getDatingDay()->getDatingDate()),
                        Carbon::now()
                    );
                });
            }

            try {
                $this->userTrialService->tempCancelIfValid($user);
                $user = $this->userDomainService->deactivateUserAccount($user);
                GracePeriodExpired::dispatch($user);
            } catch (\Throwable $th) {
                Log::error($th, [
                    'user_id' => $user->getId(),
                ]);
            }
        });
    }
}
