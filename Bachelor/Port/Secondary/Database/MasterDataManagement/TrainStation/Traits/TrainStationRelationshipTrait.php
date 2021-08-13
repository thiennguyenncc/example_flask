<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\Traits;

use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;
use Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\ModelDao\TrainStationTranslation;
use Illuminate\Support\Facades\App;

trait TrainStationRelationshipTrait
{
    /**
     * Dating place
     *
     * @return mixed
     */
    public function datingPlace()
    {
        return $this->hasMany(DatingPlace::class);
    }

    /**
     * Train Station Translations
     *
     * @return mixed
     */
    public function trainStationTranslations()
    {
        return $this->hasMany(TrainStationTranslation::class);
    }

    /**
     * Train Station Translation
     *
     * @return mixed
     */
    public function defaultTrainStationTranslation()
    {
        return $this->trainStationTranslations()
            ->whereHas('language', function ($query) {
                $query->where('short_code', App::getLocale());
            });
    }
}
