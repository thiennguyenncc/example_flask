<?php

namespace Bachelor\Application\User\EventHandler\Registers;

use Bachelor\Application\User\EventHandler\Listeners\ParticipantMainMatch\ApplyCouponsForRequestedParticipant;
use Bachelor\Application\User\EventHandler\Listeners\ParticipantMainMatch\RestartTrialIfValidAndSendNotification;
use Bachelor\Application\User\EventHandler\Listeners\ParticipantMainMatch\ReturnCouponsForCancelledParticipant;
use Bachelor\Application\User\EventHandler\Listeners\ParticipantMainMatch\ChangeToAwaitingForApproval;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\ParticipantMainMatchCancelled;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\ParticipantMainMatchCreated;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\RequestedToParticipate;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Bachelor\Application\User\EventHandler\Listeners\ParticipantMainMatch\SendAffiliateConversion;


class ParticipantMainMatchEventRegister extends EventServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        ParticipantMainMatchCreated::class => [
            ApplyCouponsForRequestedParticipant::class,
            SendAffiliateConversion::class,
        ],
        ParticipantMainMatchCancelled::class => [
            ReturnCouponsForCancelledParticipant::class
        ],
        RequestedToParticipate::class => [
            RestartTrialIfValidAndSendNotification::class,
            ChangeToAwaitingForApproval::class
        ],
    ];
}
