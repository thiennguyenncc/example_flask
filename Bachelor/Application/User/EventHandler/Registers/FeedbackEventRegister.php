<?php


namespace Bachelor\Application\User\EventHandler\Registers;


use Bachelor\Application\User\EventHandler\Listeners\Feedback\HandleCreateDatingReport;
use Bachelor\Domain\FeedbackManagement\Feedback\Event\FeedbackCreated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class FeedbackEventRegister extends EventServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        FeedbackCreated::class => [
            HandleCreateDatingReport::class
        ]
    ];
}
