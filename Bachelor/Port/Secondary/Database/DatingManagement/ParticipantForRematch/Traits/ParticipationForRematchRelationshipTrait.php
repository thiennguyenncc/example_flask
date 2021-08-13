<?php
namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantForRematch\Traits;

use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ParticipationForRematchRelationshipTrait
{

    /**
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the match dating users data to which this dating belongs to
     *
     * @return BelongsTo
     */
    public function datingDay()
    {
        return $this->belongsTo(DatingDay::class,'dating_day_id');
    }
    
}