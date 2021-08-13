<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Payment\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

trait UserTrialRelationshipTrait
{
    /**
     * Get the user to which this user trial belongs to
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
