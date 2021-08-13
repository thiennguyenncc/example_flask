<?php

namespace Bachelor\Application\Admin\EventHandler\Listeners;

use Bachelor\Application\Admin\Services\Interfaces\AdminServiceInterface;
use Bachelor\Application\Admin\EventHandler\Events\DispatchAdminAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;

class ActionLogSubscriber implements ShouldQueue
{
    /**
     * @var AdminServiceInterface
     */
    private $adminService;

    /**
     * ActionLogSubscriber constructor.
     * @param AdminServiceInterface $adminService
     */
    public function __construct(AdminServiceInterface $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * Handle the admin action event.
     *
     * @param  DispatchAdminAction  $event
     * @return void
     */
    public function handleAdminAction(DispatchAdminAction $event)
    {
        $this->adminService->actionLog($event->context);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            DispatchAdminAction::class,
            [
                ActionLogSubscriber::class, 'handleAdminAction'
            ]
        );
    }
}
