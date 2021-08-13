<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\Traits;

use Bachelor\Port\Secondary\Database\Base\Language\ModelDao\Language;
use Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\ModelDao\TrainStation;

trait TrainStationTranslationRelationshipTrait
{
    /**
     * DatingPlace
     *
     * @return mixed
     */
    public function datingPlace()
    {
        return $this->belongsTo(TrainStation::class);
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
