<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\User\Factory;

use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\User\Interfaces\UserFactoryInterface;

class UserFactory implements UserFactoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data = []): User
    {
        return new User($data);
    }
}
