<?php

namespace Bachelor\Application\User\Providers;

use Bachelor\Application\User\EventHandler\Registers\CancelDeactivateAccountEventRegister;
use Bachelor\Application\User\EventHandler\Registers\ChatEventRegister;
use Bachelor\Application\User\EventHandler\Registers\DatingEventRegister;
use Bachelor\Application\User\EventHandler\Registers\DatingReportEventRegister;
use Bachelor\Application\User\EventHandler\Registers\FeedbackEventRegister;
use Bachelor\Application\User\EventHandler\Registers\ParticipantMainMatchEventRegister;
use Bachelor\Application\User\EventHandler\Registers\ParticipantForRematchEventRegister;
use Bachelor\Application\User\EventHandler\Registers\PaymentEventRegister;
use Bachelor\Application\User\EventHandler\Registers\RegistrationEventRegister;
use Bachelor\Application\User\EventHandler\Registers\UserEventRegister;

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->register(ParticipantMainMatchEventRegister::class);
        $this->app->register(FeedbackEventRegister::class);
        $this->app->register(ParticipantForRematchEventRegister::class);
        $this->app->register(DatingEventRegister::class);
        $this->app->register(ChatEventRegister::class);
        $this->app->register(CancelDeactivateAccountEventRegister::class);
        $this->app->register(UserEventRegister::class);
        $this->app->register(PaymentEventRegister::class);
        $this->app->register(DatingReportEventRegister::class);
        $this->app->register(RegistrationEventRegister::class);
    }
}
