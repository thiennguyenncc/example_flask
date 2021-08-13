<?php

namespace Bachelor\Application\User\EventHandler\Listeners\Dating;

use Bachelor\Domain\DatingManagement\Dating\Event\DatingCancelledAfterRematch;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Utility\Helpers\Log;

class CancelledDateAfterRematchNotificationForFemOrPaidMaleIfValid
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
     * @var SubscriptionRepositoryInterface
     */
    protected SubscriptionRepositoryInterface $subscriptionRepository;

    /**
     * @var UserCouponRepositoryInterface
     */
    protected UserCouponRepositoryInterface $userCouponRepository;

    /**
     * CancelledDateAfterRematchNotificationForFemOrPaidMaleIfValid constructor.
     * @param NotificationService $notificationService
     * @param NotificationRepositoryInterface $notificationRepository
     * @param SubscriptionRepositoryInterface $subscriptionRepository
     * @param UserCouponRepositoryInterface $userCouponRepository;
     */
    public function __construct(
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        UserCouponRepositoryInterface $userCouponRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userCouponRepository = $userCouponRepository;
    }

    public function handle(DatingCancelledAfterRematch $event)
    {
        /** @var User $user */
        $user = $event->getUser();
        $subscription = $this->subscriptionRepository->getLatestSubscription($user);
        if ($user->getGender() == UserGender::Male && $subscription) {
            $key = config('notification_keys.cancelled_after_rematching_time_for_male_user');
        } elseif ($user->getGender() == UserGender::Female) {
            $key = config('notification_keys.cancelled_after_rematching_time_for_female_user');
        } else {
            return;
        }
        $notification = $this->notificationRepository->getByKey($key);
        if (!$notification) {
            Log::info('Notification with ' . $key . ' is not exist.');
            return;
        }
        if ($this->userCouponRepository->getAppliedUserCouponsForDatingDate($user, $event->getDatingDay()->getDatingDate())->isNotEmpty()) {
            $notification->mapVariable('coupon_return_text', __('api_messages.userCoupon.coupon_return_text'));
        }
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
