<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserInvitation\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

trait UserInvitationRelationshipTrait
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
