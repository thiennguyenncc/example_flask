<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Dating\Traits;

use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao\Feedback;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\TrainStation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait DatingRelationshipTrait
{
    /**
     * @return HasMany
     */
    public function datingUsers()
    {
        return $this->hasMany(DatingUser::class);
    }

    /**
     * Get the match dating users data to which this dating belongs to
     *
     * @return BelongsTo
     */
    public function datingDay()
    {
        return $this->belongsTo(DatingDay::class,"dating_day_id");
    }

    /**
     * Get the match dating users data to which this dating belongs to
     *
     * @return BelongsTo
     */
    public function datingPlace()
    {
        return $this->belongsTo(DatingPlace::class,"dating_place_id");
    }

    /**
     * @return HasMany
     */
    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Train Station
     *
     * @return mixed
     */
    public function trainStation()
    {
        return $this->belongsTo(TrainStation::class,'' ,',','');
    }
}
