<?php

namespace Bachelor\Port\Secondary\Database\Base\Admin\Traits;

use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\Admin;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao\Area;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;

trait AdminRelationshipTrait
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
     * Get the list of all the admins referred by
     *
     * @return mixed
     */
    public function referredBy()
    {
        return $this->hasMany(Admin::class);
    }

    /**
     * Get list of all prefectures created by the admin
     *
     * @return mixed
     */
    public function prefectures()
    {
        return $this->hasMany(Prefecture::class);
    }

    /**
     * Get list of all areas created by the admin
     *
     * @return mixed
     */
    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
