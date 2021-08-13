<?php

namespace Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount;

use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Events\GetReapprovedTrialMaleUser;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Facades\Log;

class ReapprovedTrialNotification
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
     * @var UserPlanRepositoryInterface
     */
    protected UserPlanRepositoryInterface $userPlanRepository;

    /**
     * ReApprovedTrialNotification constructor.
     * @param NotificationService $notificationService
     * @param NotificationRepositoryInterface $notificationRepository
     * @param UserPlanRepositoryInterface $userPlanRepository
     */
    public function __construct(
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository,
        UserPlanRepositoryInterface $userPlanRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->userPlanRepository = $userPlanRepository;
    }

    public function handle(GetReapprovedTrialMaleUser $event)
    {
        /** @var User $user */
        $user = $event->user;

        if ($user->getGender() != UserGender::Male) {
            return;
        }
        $key = config('notification_keys.reapproved_for_trial_male_user');
        $notification = $this->notificationRepository->getByKey($key);

        if (!$notification) {
            Log::info('Notification is not found.');
            return;
        }
        $content = $notification->getContent();
        $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
        $notification->mapVariable('plan_name', $userPlan->getPlan()->getCostPlan()->getName());
        $notification->mapVariable('plan_pricing', $userPlan->getPlan()->getFinalAmount());
        $notification->mapVariable('p_pricing_per_date', $userPlan->getPlan()->getAmountPerDating());
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
