<?php

namespace Bachelor\Domain\PaymentManagement\Subscription\Interfaces;

use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Collection;

interface SubscriptionRepositoryInterface
{
    /**
     * @param User $user
     * @return Subscription|null
     */
    public function getLatestSubscription(User $user): ?Subscription;

    /**
     * @param User $user
     * @return Subscription|null
     */
    public function getAppliedSubscription(User $user): ?Subscription;

    /**
     * @param string $thirdPartySubscriptionId
     * @return Subscription|null
     */
    public function getSubscriptionByThirdPartyId(string $thirdPartySubscriptionId): ?Subscription;

    /**
     * Create new subscription
     *
     * @param Subscription $plan
     * @return Subscription
     */
    public function save(Subscription $plan): Subscription;

    /**
     * @return Collection
     */
    public function getPaymentCustomersWithAppliedSubscription(): Collection;
}
