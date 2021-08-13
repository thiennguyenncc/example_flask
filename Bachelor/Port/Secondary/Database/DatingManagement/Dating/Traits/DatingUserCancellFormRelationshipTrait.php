<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Dating\Traits;

use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait DatingUserCancellFormRelationshipTrait
{
    /**
     * @return BelongsTo
     */
    public function datingUser()
    {
        return $this->belongsTo(DatingUser::class);
    }
}
