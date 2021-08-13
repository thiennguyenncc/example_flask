<?php

namespace Bachelor\Application\Admin\EventHandler\Registers;

use Bachelor\Application\Admin\EventHandler\Events\UserManagement\UserApprovedByAdmin;
use Bachelor\Application\Admin\EventHandler\Events\UserManagement\UsersCancelledByAdmin;
use Bachelor\Application\Admin\EventHandler\Events\UserManagement\UserDeactivatedByAdmin;
use Bachelor\Application\Admin\EventHandler\Listeners\UserManagement\CancelUserByAdmin;
use Bachelor\Application\Admin\EventHandler\Listeners\UserManagement\DeactivateUserByAdmin;
use Bachelor\Application\Admin\EventHandler\Listeners\UserManagement\SendApprovedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class AdminUserManagementEventRegister extends EventServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        UserApprovedByAdmin::class => [
            SendApprovedNotification::class
        ],
        UserDeactivatedByAdmin::class => [
            DeactivateUserByAdmin::class
        ],
        UsersCancelledByAdmin::class => [
            CancelUserByAdmin::class
        ],
    ];
}
