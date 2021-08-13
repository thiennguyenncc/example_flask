<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Matching\Traits;

use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait AwaitingCancelRelationship
{
    /**
     * @return BelongsTo
     */
    public function datingDay()
    {
        return $this->belongsTo(DatingDay::class);
    }
}
