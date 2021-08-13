<?php

namespace Bachelor\Domain\UserManagement\UserPreferredArea\Factories;

use Bachelor\Domain\MasterDataManagement\Area\Model\Area;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserPreferredArea\Models\UserPreferredArea;

class UserPreferredAreaFactory
{
    /**
     * @param User $user
     * @param Area $area
     * @param int $priority
     * @return UserPreferredArea
     */
    public function createUserPreferredAreaFactory(User $user, Area $area, int $priority)
    {
        return new UserPreferredArea($user, $area, $priority);
    }
}
