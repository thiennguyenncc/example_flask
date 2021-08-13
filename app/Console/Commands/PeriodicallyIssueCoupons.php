<?php

namespace App\Console\Commands;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantMainMatchProperty;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Enum\UserPaymentCustomerProperties;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserProperty;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService;
use Bachelor\Domain\UserManagement\UserCoupon\Services\UserCouponDomainService;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Utility\Helpers\CollectionHelper;
use Carbon\Carbon;
use Exception;

class PeriodicallyIssueCoupons extends BachelorBaseCommand
{
    /**
     * Add {--daily}, {--monthly}, etc if necessary
     *
     * @var string
     */
    protected $signature = 'coupon:issue {--weekly}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Periodically generate user coupons';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param UserRepositoryInterface $userRepository
     * @param SubscriptionRepositoryInterface $subscriptionRepository
     * @param ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
     * @param UserCouponDomainService $couponService
     * @param NotificationRepositoryInterface $notificationRepository
     * @param NotificationService $notificationService
     * @return void
     * @throws Exception
     */
    public function handle(
        UserRepositoryInterface $userRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        UserCouponDomainService $couponService,
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService
    ) {
        $weekly = $this->option('weekly');

        if ($weekly) {
            $userPaymentCustomers = $subscriptionRepository->getPaymentCustomersWithAppliedSubscription();
            $userPaymentCustomerIds = CollectionHelper::convEntitiesToPropertyArray($userPaymentCustomers, UserPaymentCustomerProperties::UserId);

            $usersWhoHaveDates = $participantMainMatchRepository->getParticipatedHistoryForUsersInSameWeek($userPaymentCustomerIds, Carbon::now());
            $userIdsWhoHaveDates = CollectionHelper::convEntitiesToPropertyArray($usersWhoHaveDates, ParticipantMainMatchProperty::UserId);

            $eligibleUserIds = array_diff($userPaymentCustomerIds, $userIdsWhoHaveDates);
            $eligibleUsers = $userRepository->getByIds($eligibleUserIds);

            $notificationKey = config('notification_keys.weekly_dating_coupon_issued_for_male_user');
            $notification = $notificationRepository->getByKey($notificationKey);

            foreach ($eligibleUsers as $user) {
                $this->info('Creating coupon for user id: ' . $user->getId());
                $couponService->issueCoupon(
                    $user,
                    CouponType::Dating
                );

                if ($notification) {
                    $notificationService->sendEmailNotificationToUser($user, $notification);
                }
            }
        }
        $this->info('done');
    }
}
