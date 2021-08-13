<?php

namespace Bachelor\Application\Admin\EventHandler\Listeners\UserManagement;


use Bachelor\Application\Admin\EventHandler\Events\UserManagement\UserDeactivatedByAdmin;

class DeactivateUserByAdmin
{
    /**
     * @param UserDeactivated $event
     * @return void
     */
    public function handle(UserDeactivatedByAdmin $event)
    {
        //TODO: implement action after deactivation here
    }
}
