<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserPlan\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

trait UserPlanRelationshipTrait
{
    /**
     * User to which plan belongs to
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
