<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Subscription\Repository;

use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\Subscription\ModelDao\Subscription as SubscriptionDao;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EloquentSubscriptionRepository extends EloquentBaseRepository implements SubscriptionRepositoryInterface
{

    /**
     * EloquentSubscriptionRepository constructor.
     * @param SubscriptionDao $subscription
     */
    public function __construct(SubscriptionDao $subscription)
    {
        parent::__construct($subscription);
    }

    /**
     * @param User $user
     * @return Subscription|null
     */
    public function getLatestSubscription(User $user): ?Subscription
    {
        $subscription = $this->createModelDAO()
            ->where('user_payment_customer_id', $user->getUserPaymentCustomer()?->getId())
            ->latest()
            ->first();

        return $subscription?->toDomainEntity();
    }

    /**
     * @param User $user
     * @return Subscription|null
     */
    public function getAppliedSubscription(User $user): ?Subscription
    {
        $subscription = $this->createModelDAO()
            ->where('user_payment_customer_id', $user->getUserPaymentCustomer()?->getId())
            ->whereNotin('status', [SubscriptionStatus::Canceled])
            ->first();

        return $subscription?->toDomainEntity();
    }


    /**
     * @param string $thirdPartySubscriptionId
     * @return Subscription|null
     */
    public function getSubscriptionByThirdPartyId(string $thirdPartySubscriptionId): ?Subscription
    {
        $subscription = $this->createModelDAO()
            ->where('third_party_subscription_id', $thirdPartySubscriptionId)
            ->first();

        return $subscription?->toDomainEntity();
    }

    /**
     * Create new subscription
     *
     * @param Subscription $subscription
     * @return Subscription
     */
    public function save(Subscription $subscription): Subscription
    {
        return $this->createModelDAO($subscription->getId())->saveData($subscription);
    }

    /**
     * @return Collection
     */
    public function getPaymentCustomersWithAppliedSubscription(): Collection
    {
        return $this->createQuery()
            ->where('status', '<>', SubscriptionStatus::Canceled)
            ->where('next_starts_at', '>=', Carbon::now()->toDateTimeString())
            ->with(['userPaymentCustomer'])->get()->transform(function ($subscription) {
                return $subscription->userPaymentCustomer->toDomainEntity();
            });
    }
}
