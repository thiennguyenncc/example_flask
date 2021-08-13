<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\Traits;

use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\Admin;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao\Area;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\PrefectureTranslation;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Support\Facades\App;

trait PrefectureRelationshipTrait
{
    /**
     * Get related admin
     *
     * @return mixed
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    /**
     * Get the prefecture translations
     *
     * @return mixed
     */
    public function prefectureTranslations()
    {
        return $this->hasMany(PrefectureTranslation::class);
    }

    /**
     * Get the prefecture translations
     *
     * @return mixed
     */
    public function prefectureTranslation()
    {
        return $this->hasMany(PrefectureTranslation::class)
            ->whereHas('language', function ($query) {
                $query->where('short_code', App::getLocale());
            });
    }

    /**
     * Get all area that belongs to the prefecture
     *
     * @return mixed
     */
    public function area()
    {
        return $this->hasMany(Area::class);
    }

    /**
     * Get all the user in the specified prefecture
     *
     * @return mixed
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
