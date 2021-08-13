<?php

namespace App\Console\Commands;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchService;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Illuminate\Console\Command;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CancelParticipantMainMatchOnDeadline extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cancel:participant_before_deadline';

    /**
     * @var ParticipantMainMatchService $participantMainMatchService
     */
    private ParticipantMainMatchService $participantMainMatchService;

    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    /**
     * @var UserTrialService
     */
    private UserTrialService $userTrialService;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var NotificationService
     */
    private NotificationService $notificationService;

    /**
     * @var NotificationRepositoryInterface
     */
    private NotificationRepositoryInterface $notificationRepository;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel participant at registration deadline';

    /**
     * Create a new command instance.
     *
     * @param ParticipantMainMatchService $participantMainMatchService
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        ParticipantMainMatchService $participantMainMatchService,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        UserTrialService $userTrialService,
        UserRepositoryInterface $userRepository,
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService
    ) {
        parent::__construct();
        $this->participantMainMatchService = $participantMainMatchService;
        $this->participantMainMatchService = $participantMainMatchService;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->userRepository = $userRepository;
        $this->userTrialService = $userTrialService;
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $participantsIncompleteRegister = $this->participantMainMatchRepository->getAllNotCompletedRegistrationByStatus(ParticipantsStatus::Awaiting);
        if (empty($participantsIncompleteRegister)) {
            return;
        }

        $oldestParticipants = $this->participantMainMatchService->getListForOldestDatingDayPerUserId($participantsIncompleteRegister);

        $now = Carbon::now()->startOfDay();

        $approvedMaleNotification = $this->notificationRepository->getByKey(
            config('notification_keys.auto_cancel_no_2nd_registration_male')
        );
        $approvedFemaleNotification = $this->notificationRepository->getByKey(
            config('notification_keys.auto_cancel_no_2nd_registration_female')
        );
        $awaitingMaleNotification = $this->notificationRepository->getByKey(
            config('notification_keys.unapproved_male')
        );
        $awaitingFemaleNotification = $this->notificationRepository->getByKey(
            config('notification_keys.unapproved_female')
        );

        /** @var ParticipantMainMatch $participant */
        foreach ($oldestParticipants as $participant) {
            DB::beginTransaction();
            try {
                if ($now->eq($participant->getParticipateDeadline())) {
                    /** @var User $user */
                    $user = $participant->getUser();
                    $this->participantMainMatchService->cancelAllAwaitingForUser($user);

                    if ($user->getStatus() < UserStatus::ApprovedUser) {
                        $user->cancelAwaiting();
                        $this->userRepository->save($user);

                        $notification = $user->getGender() == UserGender::Male
                            ? $awaitingMaleNotification : $awaitingFemaleNotification;
                    } elseif ($user->getStatus() == UserStatus::ApprovedUser) {
                        $this->userTrialService->tempCancelIfValid($user);

                        $notification = $user->getGender() == UserGender::Male
                            ? $approvedMaleNotification : $approvedFemaleNotification;
                    }

                    !empty($notification) ? $this->notificationService->sendEmailNotificationToUser($user, $notification)
                        : Log::error('notification is not sent in CancelParticipantMainMatchOnDeadline', [
                            'user_id' => $user->getId()
                        ]);
                }
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::error($th, [
                    'participant_id' => $participant->getId()
                ]);
            }
        }
    }
}
