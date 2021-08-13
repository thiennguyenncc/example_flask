<?php

namespace Bachelor\Application\Admin\EventHandler\Events\UserManagement;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UsersCancelledByAdmin
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Collection|User[]
     */
    private $users;

    /**
     * UsersApproved constructor.
     * @param Collection|User[] $users
     */
    public function __construct($users)
    {
        $this->users = $users;
    }
}
