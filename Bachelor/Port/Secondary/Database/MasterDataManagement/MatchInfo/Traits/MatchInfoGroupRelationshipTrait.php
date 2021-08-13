<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\Traits;

use Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\ModelDao\MatchInfo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait MatchInfoGroupRelationshipTrait
{
    /**
     * @return HasMany
     */
    public function matchInfos()
    {
        return $this->hasMany(MatchInfo::class, 'group_id');
    }
}
