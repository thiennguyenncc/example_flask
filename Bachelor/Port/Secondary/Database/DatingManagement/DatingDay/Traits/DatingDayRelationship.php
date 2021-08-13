<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\Traits;

use Bachelor\Port\Secondary\Database\DatingManagement\Matching\ModelDao\MatchingDateSetting;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait DatingDayRelationship
{
    /**
     * @return HasMany
     */
    public function matchingDateSettings()
    {
        return $this->hasMany(MatchingDateSetting::class);
    }
}
