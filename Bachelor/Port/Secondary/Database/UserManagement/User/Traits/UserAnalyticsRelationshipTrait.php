<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\User\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

trait UserAnalyticsRelationshipTrait
{
    /**
     * Get user auth related data
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
