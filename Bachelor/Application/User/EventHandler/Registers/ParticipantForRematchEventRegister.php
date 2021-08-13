<?php
namespace Bachelor\Application\User\EventHandler\Registers;

use Bachelor\Application\User\EventHandler\Listeners\ParticipantForRematch\CancelRematchingIssueCouponNotification;
use Bachelor\Application\User\EventHandler\Listeners\ParticipantForRematch\TempCancelTrialIfValid;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Events\ParticipantForRematchCancelled;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;


class ParticipantForRematchEventRegister extends EventServiceProvider
{

    /**
     *cancel_rematching_issue_coupon
     * @var array
     */
    protected $listen = [

        ParticipantForRematchCancelled::class => [
            TempCancelTrialIfValid::class,
            CancelRematchingIssueCouponNotification::class,
        ]
    ];
}
