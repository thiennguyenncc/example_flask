<?php

namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events;

use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RequestedToParticipate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
