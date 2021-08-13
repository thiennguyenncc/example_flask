<?php

namespace Bachelor\Domain\DatingManagement\Dating\Event;

use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CancelledByPartner
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public User $partner;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $partner)
    {
        $this->partner = $partner;
    }
}
