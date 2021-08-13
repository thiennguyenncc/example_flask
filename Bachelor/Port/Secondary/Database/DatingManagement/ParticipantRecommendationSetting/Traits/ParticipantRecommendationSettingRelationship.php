<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantRecommendationSetting\Traits;

use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ParticipantRecommendationSettingRelationship
{
    /**
     * @return BelongsTo
     */
    public function datingDay()
    {
        return $this->belongsTo(DatingDay::class);
    }
}
