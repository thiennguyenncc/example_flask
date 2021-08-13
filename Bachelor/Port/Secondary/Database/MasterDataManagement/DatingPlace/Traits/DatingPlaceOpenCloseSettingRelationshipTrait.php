<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Traits;

use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;

trait DatingPlaceOpenCloseSettingRelationshipTrait
{
    /**
     * Dating place
     *
     * @return mixed
     */
    public function datingPlace()
    {
        return $this->belongsTo(DatingPlace::class);
    }
}
