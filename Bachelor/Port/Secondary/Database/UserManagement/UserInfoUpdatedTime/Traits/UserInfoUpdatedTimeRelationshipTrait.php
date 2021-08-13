<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

trait UserInfoUpdatedTimeRelationshipTrait
{
    /**
     * Get user data
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);

    }
}