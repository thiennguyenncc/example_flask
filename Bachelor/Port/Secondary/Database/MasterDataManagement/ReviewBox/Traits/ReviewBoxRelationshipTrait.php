<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewBox\Traits;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Category\ModelDao\StarCategory;
use Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewPoint\ModelDao\ReviewPoint;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait ReviewBoxRelationshipTrait
{
    /**
     * @return BelongsTo
     */
    public function reviewPoint(): BelongsTo
    {
        return $this->belongsTo(ReviewPoint::class);
    }

    /**
     * @return BelongsTo
     */
    public function starCategory(): BelongsTo
    {
        return $this->belongsTo(StarCategory::class);
    }
}
