<?php

namespace Bachelor\Port\Secondary\PaymentManagement\Stripe\Repository;

use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription as SubscriptionEntity;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\ExtUserPlanRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\PaymentManagement\Stripe\Base\StripeBaseRepository;
use Stripe\Exception\ApiErrorException;
use Stripe\Subscription;
use Stripe\SubscriptionSchedule;

class StripeSubscriptionSchedule extends StripeBaseRepository implements ExtUserPlanRepositoryInterface
{
    /*
     * Stripe Subscription
     */
    private Subscription $stripeSubscription;

    private SubscriptionSchedule $stripeSubscriptionSchedule;

    /**
     * Retrieve subscription
     *
     * @param SubscriptionEntity $subscription
     * @return object
     * @throws ApiErrorException
     */
    public function retrieveSubscription(SubscriptionEntity $subscription): bool
    {
        return (bool) $this->stripeSubscription = Subscription::retrieve($subscription->getThirdPartySubscriptionId());
    }

    /**
     * Undocumented function
     *
     * @param SubscriptionEntity $subscription
     * @param Plan $newPlan
     * @return object
     * @throws ApiErrorException
     */
    public function updateSubscription(SubscriptionEntity $subscription, Plan $newPlan): bool
    {
        $payload =  [
            'items' => [
                [
                    'id' => $this->stripeSubscription->items->data[0]->id,
                    'price' => $newPlan->getThirdPartyPlanId(),
                ],
            ]
        ];

        //this is update immdiately
        return (bool) $this->stripeSubscription = Subscription::update($subscription->getThirdPartySubscriptionId(), $payload);
    }

    /**
     * schedule next plan
     *
     * @param SubscriptionEntity $subscription
     * @param Plan $currentPlan
     * @param Plan $newPlan
     * @return object
     * @throws ApiErrorException
     */
    private function createSubscriptionSchedule(SubscriptionEntity $subscription): bool
    {
        $payload = [
            'from_subscription' => $subscription->getThirdPartySubscriptionId()
        ];
        return (bool) $this->stripeSubscriptionSchedule = SubscriptionSchedule::create($payload);
    }

    /**
     * schedule next plan
     *
     * @param SubscriptionEntity $subscription
     * @param Plan $currentPlan
     * @param Plan $newPlan
     * @return object
     * @throws ApiErrorException
     */
    public function updateSubscriptionSchedule(User $user, Plan $currentPlan, Plan $newPlan): bool
    {
        $currentItems[]['price'] = $currentPlan->getThirdPartyPlanId();
        $nextItems[]['price'] = $newPlan->getThirdPartyPlanId();
        $payload = [
            'end_behavior' => 'release',
            'phases' => [
                [
                    'start_date' => $this->stripeSubscription->current_period_start,
                    'items' => $currentItems,
                    'iterations' => 1,
                ],
                [
                    'start_date' => $this->stripeSubscription->current_period_end,
                    'items' => $nextItems,
                    'iterations' => 1,
                ],
            ]
        ];
        return (bool) $this->stripeSubscriptionSchedule = SubscriptionSchedule::update($this->stripeSubscription->schedule, $payload);
    }

    /**
     * schedule next plan
     *
     * @param SubscriptionEntity $subscription
     * @param User $user
     * @param Plan $currentPlan
     * @param Plan $newPlan
     * @return object
     * @throws ApiErrorException
     */
    public function scheduleNextPlan(SubscriptionEntity $subscription, User $user, Plan $currentPlan, Plan $newPlan): bool
    {
        $this->retrieveSubscription($subscription);

        if (!$this->stripeSubscription->schedule) {
            $this->createSubscriptionSchedule($subscription);
        }

        return $this->updateSubscriptionSchedule($user, $currentPlan, $newPlan);
    }
}
