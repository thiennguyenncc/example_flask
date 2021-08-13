<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\Traits;

use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ParticipantRelationshipTrait
{
    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function datingDay()
    {
        return $this->belongsTo(DatingDay::class);
    }
}
