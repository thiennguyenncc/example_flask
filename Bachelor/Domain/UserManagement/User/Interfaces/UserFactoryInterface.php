<?php

namespace Bachelor\Domain\UserManagement\User\Interfaces;

use Bachelor\Domain\UserManagement\User\Models\User;

interface UserFactoryInterface
{
    /**
     * @param array $data
     * @return User
     */
    public function create(array $data = []): User;
}
