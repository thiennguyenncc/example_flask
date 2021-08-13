<?php

namespace Bachelor\Application\User\EventHandler\Registers;

use Bachelor\Application\User\EventHandler\Listeners\Registration\SendAffiliateConversion;
use Bachelor\Domain\UserManagement\Registration\Events\GottenStepZeroData;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class RegistrationEventRegister extends EventServiceProvider
{
    /**
     *
     * @var array
     */
    protected $listen = [
        GottenStepZeroData::class => [
            SendAffiliateConversion::class
        ],
    ];
}
