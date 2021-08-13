<?php

namespace Bachelor\Application\Admin\EventHandler\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DispatchAdminAction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /*
     * Logging context
     */
    public $context;

    /**
     * Create a new event instance.
     *
     * @param array $context
     */
    public function __construct(array $context)
    {
        $this->context = $context;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('admin-action-log');
    }
}
