<?php

namespace Bachelor\Application\Admin\EventHandler\Listeners\UserManagement;


use Bachelor\Application\Admin\EventHandler\Events\UserManagement\UsersCancelledByAdmin;

class CancelUserByAdmin
{
    /**
     * @param UsersCancelled $event
     * @return void
     */
    public function handle(UsersCancelledByAdmin $event)
    {
        //TODO: implement Cancelled action here
    }
}
