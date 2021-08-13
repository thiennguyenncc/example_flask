<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserProfile\Traits;

use Bachelor\Port\Secondary\Database\MasterDataManagement\School\ModelDao\School;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

trait UserProfileRelationshipTrait
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
    /**
     * Get user data
     *
     * @return mixed
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
