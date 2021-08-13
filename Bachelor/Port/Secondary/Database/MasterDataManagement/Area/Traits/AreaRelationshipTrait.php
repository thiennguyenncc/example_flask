<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Area\Traits;

use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\Admin;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao\AreaTranslation;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;

trait AreaRelationshipTrait
{
    /**
     * Get related admin
     *
     * @return BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * dating Place translations
     *
     * @return HasMany
     */
    public function areaTranslations()
    {
        return $this->hasMany(AreaTranslation::class);
    }

    /**
     * Get the prefecture translation
     *
     * @return HasMany
     */
    public function areaTranslation()
    {
        return $this->hasMany(AreaTranslation::class)
            ->whereHas('language', function ($query) {
                $query->where('short_code', App::getLocale());
            });
    }

    /**
     * Get data to the prefecture it belongs to
     *
     * @return BelongsTo
     */
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }
}
