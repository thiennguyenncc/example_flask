<?php

namespace Bachelor\Domain\PaymentManagement\UserPlan\Interfaces;

use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\UserManagement\User\Models\User;
use Stripe\Exception\ApiErrorException;

interface ExtUserPlanRepositoryInterface
{
    /**
     * schedule next plan
     *
     * @param Subscription $subscription
     * @param Plan $currentPlan
     * @param Plan $newPlan
     * @return bool
     * @throws ApiErrorException
     */
    public function updateSubscriptionSchedule(User $user, Plan $currentPlan, Plan $newPlan): bool;

    /**
     * Undocumented function
     *
     * @param Subscription $subscription
     * @param Plan $newPlan
     * @return bool
     * @throws ApiErrorException
     */
    public function updateSubscription(Subscription $subscription, Plan $newPlan): bool;

    /**
     * schedule next plan
     *
     * @param Subscription $subscription
     * @param User $user
     * @param Plan $currentPlan
     * @param Plan $newPlan
     * @return bool
     * @throws ApiErrorException
     */
    public function scheduleNextPlan(Subscription $subscription, User $user, Plan $currentPlan, Plan $newPlan): bool;
}
