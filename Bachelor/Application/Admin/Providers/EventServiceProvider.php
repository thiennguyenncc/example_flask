<?php

namespace Bachelor\Application\Admin\Providers;

use Bachelor\Application\Admin\EventHandler\Registers\AdminUserManagementEventRegister;

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->register(AdminUserManagementEventRegister::class);
    }
}
