<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Category\Traits;

use Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewBox\ModelDao\ReviewBox;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait StarCategoryRelationshipTrait
{
    /**
     * @return HasMany
     */
    public function reviewBoxes(): HasMany
    {
        return $this->hasMany(ReviewBox::class);
    }
}
