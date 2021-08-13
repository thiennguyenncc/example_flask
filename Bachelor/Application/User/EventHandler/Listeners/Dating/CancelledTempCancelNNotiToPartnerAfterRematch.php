<?php

namespace Bachelor\Application\User\EventHandler\Listeners\Dating;

use Bachelor\Domain\DatingManagement\Dating\Event\DatingCancelledAfterRematch;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Utility\Helpers\Log;

class CancelledTempCancelNNotiToPartnerAfterRematch
{
    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @var NotificationRepositoryInterface
     */
    protected NotificationRepositoryInterface $notificationRepository;

    /**
     * @var UserTrialRepositoryInterface
     */
    protected UserTrialRepositoryInterface $userTrialRepository;

    /**
     * @var UserTrialService
     */
    protected UserTrialService $userTrialService;

    /**
     * CancelRematchingOneMoreTrialNotification constructor.
     * @param NotificationService $notificationService
     * @param NotificationRepositoryInterface $notificationRepository
     * @param UserTrialRepositoryInterface $userTrialRepository
     */
    public function __construct(
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        UserTrialService $userTrialService
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->userTrialRepository = $userTrialRepository;
        $this->userTrialService = $userTrialService;
    }

    public function handle(DatingCancelledAfterRematch $event)
    {
        /** @var User $user */
        $user = $event->partner;
        $userTrial = $this->userTrialService->tempCancelIfValid($user);

        // Check only send notification to trial user
        if (!$userTrial) {
            Log::info('User has ' . $user->getId() . ', who is not trial user');
            return;
        }
        
        $key = config('notification_keys.cancelled_after_rematching_time_trial_male_user');
        $notification = $this->notificationRepository->getByKey($key);
        if (!$notification) {
            Log::info('Notification with ' . $key . ' is not exist.');
            return;
        }
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
