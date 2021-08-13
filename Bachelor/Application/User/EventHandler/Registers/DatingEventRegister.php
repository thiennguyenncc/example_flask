<?php

namespace Bachelor\Application\User\EventHandler\Registers;

use Bachelor\Application\User\EventHandler\Listeners\Dating\CancelledDateAfterRematchNotificationForFemOrPaidMaleIfValid;
use Bachelor\Application\User\EventHandler\Listeners\Dating\CancelledTempCancelNNotiToPartnerAfterRematch;
use Bachelor\Application\User\EventHandler\Listeners\Dating\CancelledTempCancelNOneMoreTrialNoti;
use Bachelor\Application\User\EventHandler\Listeners\Dating\CancelRematchingIssueCouponNotification;
use Bachelor\Application\User\EventHandler\Listeners\Dating\PartnerCancelParticipateRematchingNotification;
use Bachelor\Application\User\EventHandler\Listeners\Dating\ReportedCancellationNotification;
use Bachelor\Application\User\EventHandler\Listeners\Dating\TempCancelNOneMoreTrialNotification;
use Bachelor\Application\User\EventHandler\Listeners\Dating\TempCancelTrialIfValid;
use Bachelor\Domain\DatingManagement\Dating\Event\DatingCancelledAfterRematch;
use Bachelor\Domain\DatingManagement\Dating\Event\CancelledByPartner;
use Bachelor\Domain\DatingManagement\Dating\Event\CancelledByPartnerNoRematch;
use Bachelor\Domain\DatingManagement\Dating\Event\DatingCancelled;
use Bachelor\Domain\DatingManagement\Dating\Event\PartnerCancelledBeforeRematch;
use Bachelor\Domain\DatingManagement\Dating\Event\DatingCancelledBeforeRematch;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class DatingEventRegister extends EventServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        CancelledByPartner::class => [
            ReportedCancellationNotification::class,
            TempCancelTrialIfValid::class,
        ],
        CancelledByPartnerNoRematch::class => [
            TempCancelNOneMoreTrialNotification::class,
        ],
        DatingCancelledAfterRematch::class => [
            CancelledDateAfterRematchNotificationForFemOrPaidMaleIfValid::class,
            CancelledTempCancelNNotiToPartnerAfterRematch::class
        ],
        PartnerCancelledBeforeRematch::class => [
            PartnerCancelParticipateRematchingNotification::class
        ],
        DatingCancelled::class => [
            CancelledTempCancelNOneMoreTrialNoti::class
        ],
        DatingCancelledBeforeRematch::class => [
            CancelRematchingIssueCouponNotification::class
        ]
    ];
}
