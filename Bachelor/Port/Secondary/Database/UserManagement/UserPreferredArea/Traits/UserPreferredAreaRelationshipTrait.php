<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserPreferredArea\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

trait UserPreferredAreaRelationshipTrait
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
