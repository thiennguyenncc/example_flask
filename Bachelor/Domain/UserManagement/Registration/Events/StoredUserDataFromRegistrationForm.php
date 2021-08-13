<?php

namespace Bachelor\Domain\UserManagement\Registration\Events;

use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoredUserDataFromRegistrationForm
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public User $user;
    
    /**
     * @var int
     */
    public int $step;
    
    /**
     * Create a new event instance.
     *
     * @param User $user
     */
    public function __construct(User $user, $step)
    {
        $this->user = $user;
        $this->step = $step;
    }
}
