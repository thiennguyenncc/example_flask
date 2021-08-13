<?php

namespace Bachelor\Application\User\EventHandler\Registers;

use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\ReactivatedNotification;
use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\ReactivatedTrialUserNotification;
use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\ReapprovedNotification;
use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\ReapprovedTrialNotification;
use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\RequestedCancellationNotification;
use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\RequestedDeactivationNotification;
use Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount\RequestedOneMoreTrialNotification;
use Bachelor\Domain\UserManagement\User\Events\GetReactivatedFemaleOrPaidMale;
use Bachelor\Domain\UserManagement\User\Events\GetReapprovedFemaleOrPaidMale;
use Bachelor\Domain\UserManagement\User\Events\GetReapprovedTrialMaleUser;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Bachelor\Domain\UserManagement\User\Events\GetReactivatedTrialMaleUser;
use Bachelor\Domain\UserManagement\User\Events\SentCancellationForm;
use Bachelor\Domain\UserManagement\User\Events\SentDeactivationForm;
use Bachelor\Domain\UserManagement\User\Events\SentOneMoreTrialRequest;

class UserEventRegister extends EventServiceProvider
{
    /**
     *
     * @var array
     */
    protected $listen = [
        SentCancellationForm::class => [
            RequestedCancellationNotification::class
        ],
        SentDeactivationForm::class => [
            RequestedDeactivationNotification::class
        ],
        SentOneMoreTrialRequest::class => [
            RequestedOneMoreTrialNotification::class
        ],
        GetReapprovedFemaleOrPaidMale::class => [
            ReapprovedNotification::class
        ],
        GetReactivatedFemaleOrPaidMale::class => [
            ReactivatedNotification::class
        ],
        GetReactivatedTrialMaleUser::class => [
            ReactivatedTrialUserNotification::class
        ],
        GetReapprovedTrialMaleUser::class => [
            ReapprovedTrialNotification::class
        ],
    ];
}
