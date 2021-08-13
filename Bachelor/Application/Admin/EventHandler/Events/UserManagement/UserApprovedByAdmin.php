<?php

namespace Bachelor\Application\Admin\EventHandler\Events\UserManagement;

use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserApprovedByAdmin
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * UserApproved constructor.
     * @param User $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getUser(){
        return $this->user;
    }

}
