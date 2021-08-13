<?php

namespace Bachelor\Application\User\EventHandler\Listeners\Plan;

use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\Plan\Events\UpgradePlan;
use Bachelor\Domain\PaymentManagement\UserPlan\Services\UserPlanService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\PaymentManagement\Subscription\Services\SubscriptionService;
use Illuminate\Support\Facades\Log;

class UpgradePlanNotification
{
    /**
     * @var NotificationRepositoryInterface
     */
    protected NotificationRepositoryInterface $notificationRepository;

    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @var SubscriptionService
     */
    protected SubscriptionService $subscriptionService;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        SubscriptionService $subscriptionService
    )
    {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->subscriptionService = $subscriptionService;
    }

    public function handle(UpgradePlan $event)
    {
        /** @var User $user */
        $user = $event->getUser();
        $newPlan = $event->getNewPlan();

        if ($user->getGender() == UserGender::Female) {
            return;
        }
        $key = config('notification_keys.upgrade_plan');
        $notification = $this->notificationRepository->getByKey($key);

        if (! $notification) {
            Log::info('Notification is not found.');
            return;
        }

        $notification->mapVariable('new_plan', $newPlan->getCostPlan()->getName());
        $notification->mapVariable('next_renewal_day', $this->subscriptionService->calculateNextRenewalDay($user));
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
