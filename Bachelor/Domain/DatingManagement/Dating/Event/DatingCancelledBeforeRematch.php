<?php

namespace Bachelor\Domain\DatingManagement\Dating\Event;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DatingCancelledBeforeRematch
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    public User $user;

    /**
     *
     * @var DatingDay
     */
    private DatingDay $datingDay;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param DatingDay $datingDay
     */
    public function __construct(User $user, DatingDay $datingDay)
    {
        $this->user = $user;
        $this->datingDay = $datingDay;
    }

    /**
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     *
     * @return DatingDay
     */
    public function getDatingDay(): DatingDay
    {
        return $this->datingDay;
    }
}
