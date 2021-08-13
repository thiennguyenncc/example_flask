<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\Traits;

use Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\ModelDao\MatchInfoGroup;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait MatchInfoRelationshipTrait
{
    /**
     * @return BelongsTo
     */
    public function matchInfoGroup()
    {
        return $this->belongsTo(MatchInfoGroup::class, 'group_id');
    }
}
