<?php

namespace Bachelor\Port\Secondary\Database\NotificationManagement\Notification\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

trait NotificationRelationshipTrait
{
    /**
     * Get the user to which this notification belongs to
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class );
    }

    /**
     * Get the owning notifiable model.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }
}
