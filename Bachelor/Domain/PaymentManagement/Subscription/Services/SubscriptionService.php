<?php

namespace Bachelor\Domain\PaymentManagement\Subscription\Services;

use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\ExtSubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Services\UserPaymentCustomerService;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Utility\Helpers\Utility;
use Carbon\Carbon;

class SubscriptionService
{
    /**
     * @var SubscriptionRepositoryInterface
     */
    private SubscriptionRepositoryInterface $subscriptionRepository;

    private UserTrialRepositoryInterface $userTrialRepository;

    private ExtSubscriptionRepositoryInterface $extSubscriptionRepository;

    /**
     * SubscriptionService constructor.
     * @param SubscriptionRepositoryInterface $subscriptionRepository
     */
    public function __construct(
        SubscriptionRepositoryInterface $subscriptionRepository,
        UserPaymentCustomerService $userPaymentCustomerService,
        UserTrialRepositoryInterface $userTrialRepository,
        ExtSubscriptionRepositoryInterface $extSubscriptionRepository
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userPaymentCustomerService = $userPaymentCustomerService;
        $this->userTrialRepository = $userTrialRepository;
        $this->extSubscriptionRepository = $extSubscriptionRepository;
    }

    /**
     * @param User $user
     * @return string
     */
    public function calculateNextRenewalDay(User $user): string
    {
        $userTrial = $this->userTrialRepository->getLatestTrialByUser($user);
        if ($userTrial->getStatus() == TrialStatus::Completed) {
            $subscription = $this->subscriptionRepository->getLatestSubscription($user);
            $nextRenewalDay = $subscription->getJaEndsAt();
        } else {
            $nextRenewalDay = $userTrial->getJaTrialEnd();
        }

        return $nextRenewalDay;
    }

    public function cancelUsersSubscription(User $user): ?Subscription
    {
        $subscription = $this->subscriptionRepository->getAppliedSubscription($user);

        if (!$subscription) return null;
        $this->extSubscriptionRepository->cancelSubscription($subscription);

        $result = Utility::wait(
            function () use ($subscription) {
                $subscription = $this->subscriptionRepository->getSubscriptionByThirdPartyId($subscription->getThirdPartySubscriptionId());
                return $subscription->getStatus() === SubscriptionStatus::Canceled;
            }
        );

        return $result ? $subscription : null;
    }
}
