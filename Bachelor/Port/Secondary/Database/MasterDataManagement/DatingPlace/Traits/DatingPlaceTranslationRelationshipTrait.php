<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Traits;

use Bachelor\Port\Secondary\Database\Base\Language\ModelDao\Language;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;

trait DatingPlaceTranslationRelationshipTrait
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

    /**
     * Get the register option translations
     *
     * @return mixed
     */
    public function language(): mixed
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
