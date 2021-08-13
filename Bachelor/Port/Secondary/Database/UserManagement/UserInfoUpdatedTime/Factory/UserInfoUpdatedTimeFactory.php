<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\Factory;

use Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\ModelDao\UserInfoUpdatedTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserInfoUpdatedTimeFactory extends Factory
{
    protected $model = UserInfoUpdatedTime::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }
}
