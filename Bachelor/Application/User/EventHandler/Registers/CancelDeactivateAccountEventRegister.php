<?php

namespace Bachelor\Application\User\EventHandler\Registers;

use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\CancelSubscriptionIfValid;
use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\DiscardAllCoupon;
use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\TempCancelTrialIfValid;
use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\UncollectiveDeactivatedAccountNotification;
use Bachelor\Domain\PaymentManagement\Payment\Events\GracePeriodExpired;
use Bachelor\Domain\UserManagement\User\Events\CancelledAccount;
use Bachelor\Domain\UserManagement\User\Events\DeactivatedAccount;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class CancelDeactivateAccountEventRegister extends EventServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        GracePeriodExpired::class => [
            UncollectiveDeactivatedAccountNotification::class
        ],
        DeactivatedAccount::class => [
            TempCancelTrialIfValid::class,
            CancelSubscriptionIfValid::class
        ],
        CancelledAccount::class => [
            TempCancelTrialIfValid::class,
            CancelSubscriptionIfValid::class,
            DiscardAllCoupon::class
        ]
    ];
}
