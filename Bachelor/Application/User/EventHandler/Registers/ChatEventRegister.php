<?php

namespace Bachelor\Application\User\EventHandler\Registers;

use Bachelor\Application\User\EventHandler\Listeners\Chat\ReceivedChatNotification;
use Bachelor\Domain\Communication\Chat\Event\ChatReceived;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class ChatEventRegister extends EventServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        ChatReceived::class => [
            ReceivedChatNotification::class
        ]
    ];
}
