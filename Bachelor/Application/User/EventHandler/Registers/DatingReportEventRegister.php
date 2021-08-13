<?php


namespace Bachelor\Application\User\EventHandler\Registers;

use Bachelor\Application\User\EventHandler\Listeners\DatingReport\UpdateUserBRate;
use Bachelor\Domain\FeedbackManagement\DatingReport\Events\DatingReportGenerated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class DatingReportEventRegister extends EventServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        DatingReportGenerated::class => [
            UpdateUserBRate::class
        ]
    ];
}
