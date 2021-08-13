<?php

namespace Bachelor\Port\Secondary\PaymentManagement\Stripe\Repository;

use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\ExtSubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription as SubscriptionEntity;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Port\Secondary\PaymentManagement\Stripe\Base\StripeBaseRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\App;
use Stripe\Exception\ApiErrorException;
use Stripe\Subscription;

class StripeSubscription extends StripeBaseRepository implements ExtSubscriptionRepositoryInterface
{
    /*
     * Stripe Subscription
     */
    private Subscription $stripeSubscription;

    /**
     * Retrieve subscription
     *
     * @param SubscriptionEntity $subscription
     * @return bool
     * @throws ApiErrorException
     */
    public function retrieveSubscription(SubscriptionEntity $subscription): bool
    {
        return (bool)$this->stripeSubscription = Subscription::retrieve($subscription->getThirdPartySubscriptionId());
    }

    /**
     * Retrieve customer subscriptions
     *
     * @param array $payload
     * @return bool
     * @throws ApiErrorException
     */
    public function retrieveCustomerSubscriptions(array $payload): bool
    {
        return (bool)$this->subscriptions = Subscription::all($payload);
    }

    /**
     * Create Subscription
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @param Plan $plan
     * @return bool
     * @throws ApiErrorException
     */
    public function createSubscription(UserPaymentCustomer $userPaymentCustomer, Plan $plan): bool
    {
        $items[]['price'] = $plan->getThirdPartyPlanId();
        if(!App::environment('production') && env('FAKE_CURRENT_TIME')) {
            $testNow = Carbon::now()->toDateTimeString();
            Carbon::setTestNow();
            $trial_end = Carbon::now()->addMinute()->timestamp;
            Carbon::setTestNow($testNow);
        } else {
            $trial_end = Carbon::now()->addMinute()->timestamp;
        }
        $payload = [
            'customer' => $userPaymentCustomer->getThirdPartyCustomerId(),
            'items' => $items,
            'trial_end' => $trial_end
        ];

        return (bool)$this->stripeSubscription = Subscription::create($payload);
    }

    /**
     * Cancel Subscription
     *
     * @param SubscriptionEntity $subscription
     * @return bool
     * @throws ApiErrorException
     */
    public function cancelSubscription(SubscriptionEntity $subscription): bool
    {
        if ($this->retrieveSubscription($subscription)) {
            return (bool)$this->stripeSubscription->cancel();
        };
        return false;
    }
}
