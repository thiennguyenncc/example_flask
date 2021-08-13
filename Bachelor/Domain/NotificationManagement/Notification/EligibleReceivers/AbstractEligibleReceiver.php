<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Collection;

abstract class AbstractEligibleReceiver
{
    /**
     * @return Collection|User[]
     */
    abstract public function retrieve(): Collection;

}
