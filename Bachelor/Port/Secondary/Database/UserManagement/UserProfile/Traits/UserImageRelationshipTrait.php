<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserProfile\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait UserImageRelationshipTrait
{
    /**
     * Get the user to which this image belongs to
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
