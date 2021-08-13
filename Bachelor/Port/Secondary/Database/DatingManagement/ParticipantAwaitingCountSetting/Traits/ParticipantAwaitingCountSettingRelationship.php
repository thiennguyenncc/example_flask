<?php


namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\Traits;


use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ParticipantAwaitingCountSettingRelationship
{
    /**
     * @return BelongsTo
     */
    public function datingDay()
    {
        return $this->belongsTo(DatingDay::class);
    }
}
