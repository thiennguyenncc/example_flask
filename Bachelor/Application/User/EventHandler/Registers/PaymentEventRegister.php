<?php

namespace Bachelor\Application\User\EventHandler\Registers;

use Bachelor\Application\User\EventHandler\Listeners\PaymentCard\CompleteRegistrationStepIfValid;
use Bachelor\Application\User\EventHandler\Listeners\Plan\DowngradePlanNotification;
use Bachelor\Application\User\EventHandler\Listeners\Plan\UpgradePlanNotification;
use Bachelor\Application\User\EventHandler\Listeners\UserTrial\SendAffiliateConversion;
use Bachelor\Domain\PaymentManagement\PaymentCard\Events\StoredNewCard;
use Bachelor\Domain\PaymentManagement\Plan\Events\DowngradePlan;
use Bachelor\Domain\PaymentManagement\Plan\Events\UpgradePlan;
use Bachelor\Domain\UserManagement\User\Events\CompletedTrial;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class PaymentEventRegister extends EventServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        UpgradePlan::class => [
            UpgradePlanNotification::class
        ],
        DowngradePlan::class => [
            DowngradePlanNotification::class
        ],
        CompletedTrial::class => [
            SendAffiliateConversion::class
        ],
        StoredNewCard::class => [
            CompleteRegistrationStepIfValid::class
        ]
    ];
}
