<?php

namespace App\Providers;

use Bachelor\Application\User\EventHandler\Events\DispatchWebhook;
use Bachelor\Application\User\EventHandler\Listeners\WebhookLog;
use Bachelor\Application\Admin\EventHandler\Listeners\ActionLogSubscriber as AdminLogSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        DispatchWebhook::class => [
            WebhookLog::class
        ]
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        AdminLogSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
