<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Traits;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao\Area;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlaceOpenCloseSetting;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlaceTranslation;
use Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\ModelDao\TrainStation;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

trait DatingPlaceRelationshipTrait
{
    /**
     * Dating place translations
     *
     * @return HasMany
     */
    public function datingPlaceTranslations()
    {
        return $this->hasMany(DatingPlaceTranslation::class);
    }

    /**
     * Dating place open close settings
     *
     * @return HasMany
     */
    public function datingPlaceOpenCloseSettings()
    {
        return $this->hasMany(DatingPlaceOpenCloseSetting::class);
    }

    /**
     * Dating place translation
     *
     * @return HasMany
     */
    public function datingPlaceTranslation()
    {
        return $this->hasMany(DatingPlaceTranslation::class)
            ->whereHas('language', function ($query) {
                $query->where('short_code', App::getLocale());
            });
    }

    /**
     * area translation
     *
     * @return BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Train Station
     *
     * @return BelongsTo
     */
    public function trainStation()
    {
        return $this->belongsTo(TrainStation::class);
    }
}
