<?php

namespace Bachelor\Domain\FeedbackManagement\Feedback\Event;

use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FeedbackCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int
     */
    protected User $user;

    /**
     * @var Dating
     */
    protected Dating $datingEntity;

    public function __construct(User $user, Dating $datingEntity)
    {
        $this->user = $user;
        $this->datingEntity = $datingEntity;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Dating
     */
    public function getDatingEntity(): Dating
    {
        return $this->datingEntity;
    }
}
