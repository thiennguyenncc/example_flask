<?php

namespace App\Console\Commands;

use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Models\UserTrial;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Support\Facades\DB;

class CompleteTrial extends BachelorBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'complete:trial';

    protected  UserTrialRepositoryInterface $userTrialRepository;

    protected  UserTrialService $userTrialService;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create subscription for user has trial ends today';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        UserTrialRepositoryInterface $userTrialRepository,
        UserTrialService $userTrialService
    ) {
        parent::__construct();
        $this->userTrialRepository = $userTrialRepository;
        $this->userTrialService = $userTrialService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $startTime = microtime(true);

        $this->_make();

        $time = microtime(true) - $startTime;
        $this->info("Created Subscription Successfully | took $time ms");
    }

    private function _make()
    {
        $trials = $this->userTrialRepository->getFinishedActiveUserTrialCollection();
        $trials->each(function (UserTrial $trial) {
            DB::beginTransaction();
            try {
                $this->userTrialService->completeTrial($trial);
                $this->info('Completed Trial for user id: ' . $trial->getUserId());
                DB::commit();
            } catch (\Throwable $th) {
                $this->info('Failed to Complete Trial for user id: ' . $trial->getUserId());
                DB::rollBack();
                Log::error($th->getMessage());
            }
        });
    }
}
