<?php

namespace Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount;

use Bachelor\Domain\PaymentManagement\Subscription\Services\SubscriptionService;
use Bachelor\Domain\UserManagement\User\Events\CancelledAccount;
use Bachelor\Domain\UserManagement\User\Events\DeactivatedAccount;
use Bachelor\Domain\UserManagement\User\Models\User;

class CancelSubscriptionIfValid
{
    /**
     * @var SubscriptionService
     */
    protected SubscriptionService $subscriptionService;

    public function __construct(
        SubscriptionService $subscriptionService
    ) {
        $this->subscriptionService = $subscriptionService;
    }

    public function handle(DeactivatedAccount|CancelledAccount $event)
    {
        /** @var User $user */
        $user = $event->user;

        $this->subscriptionService->cancelUsersSubscription($user);
    }
}
