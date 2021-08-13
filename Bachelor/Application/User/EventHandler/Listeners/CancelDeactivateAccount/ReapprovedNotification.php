<?php

namespace Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount;

use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Events\GetReapprovedFemaleOrPaidMale;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReapprovedNotification
{
    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @var UserPlanRepositoryInterface
     */
    protected UserPlanRepositoryInterface $userPlanRepository;

    /**
     * @var SubscriptionRepositoryInterface
     */
    protected SubscriptionRepositoryInterface $subscriptionRepository;

    /**
     * @var NotificationRepositoryInterface
     */
    protected NotificationRepositoryInterface $notificationRepository;

    public function __construct(
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        SubscriptionRepositoryInterface $subscriptionRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->userPlanRepository = $userPlanRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function handle(GetReapprovedFemaleOrPaidMale $event)
    {
        /** @var User $user */
        $user = $event->user;

        if ($user->getGender() == UserGender::Male) {
            $key = config('notification_keys.reapproved_for_male_user');
            $notification = $this->notificationRepository->getByKey($key);

            if (!$notification) {
                Log::info('Notification is not found.');
                return;
            }
            $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
            $subscription = $this->subscriptionRepository->getAppliedSubscription($user);
            $notification->mapVariable('subscription_start_date', Carbon::parse($subscription->getStartsAt())->format('Y-m-d'));
            $notification->mapVariable('subscription_end_date', Carbon::parse($subscription->getEndsAt())->format('Y-m-d'));
            $notification->mapVariable('plan_name', $userPlan->getPlan()->getName());
            $notification->mapVariable('plan_pricing', $userPlan->getPlan()->getFinalAmount());
        } else {
            $key = config('notification_keys.reapproved_for_female_user');
            $notification = $this->notificationRepository->getByKey($key);

            if (!$notification) {
                return;
            }
        }

        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
