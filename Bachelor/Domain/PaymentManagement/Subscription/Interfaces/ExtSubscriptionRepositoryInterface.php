<?php

namespace Bachelor\Domain\PaymentManagement\Subscription\Interfaces;

use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Stripe\Exception\ApiErrorException;

interface ExtSubscriptionRepositoryInterface
{
    /**
     * Retrieve subscription
     *
     * @param Subscription $subscription
     * @return bool
     * @throws ApiErrorException
     */
    public function retrieveSubscription(Subscription $subscription): bool;

    /**
     * Retrieve customer subscriptions
     *
     * @param array $payload
     * @return bool
     */
    public function retrieveCustomerSubscriptions(array $payload): bool;

    /**
     * Create Subscription
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @param Plan $plan
     * @return bool
     * @throws ApiErrorException
     */
    public function createSubscription(UserPaymentCustomer $userPaymentCustomer, Plan $plan): bool;

    /**
     * Cancel Subscription
     *
     * @param Subscription $subscription
     * @return bool
     * @throws ApiErrorException
     */
    public function cancelSubscription(Subscription $subscription): bool;
}
