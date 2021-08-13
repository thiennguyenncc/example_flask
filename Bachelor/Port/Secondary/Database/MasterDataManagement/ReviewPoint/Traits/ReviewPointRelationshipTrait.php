<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewPoint\Traits;

use Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewBox\ModelDao\ReviewBox;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait ReviewPointRelationshipTrait
{

    /**
     * @return HasOne
     */
    public function reviewBox(): HasOne
    {
        return $this->hasOne(ReviewBox::class);
    }
}
