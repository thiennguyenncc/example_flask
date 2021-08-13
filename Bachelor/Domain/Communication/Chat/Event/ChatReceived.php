<?php

namespace Bachelor\Domain\Communication\Chat\Event;

use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatReceived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public User $receiverUser;

    /**
     * @var int
     */
    public string $roomId;

    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(
        User $receiverUser,
        string $roomId
    ) {
        $this->receiverUser = $receiverUser;
        $this->roomId = $roomId;
    }
}
