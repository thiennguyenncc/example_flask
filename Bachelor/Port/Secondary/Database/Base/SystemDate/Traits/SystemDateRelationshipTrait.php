<?php
namespace Bachelor\Port\Secondary\Database\Base\SystemDate\Traits;

use Bachelor\Port\Secondary\Database\Base\TimeSetting\ModelDao\TimeSetting;

trait SystemDateRelationshipTrait
{

    /**
     * Get time cycle settings
     */
    public function time_setting()
    {
        return $this->hasOne(TimeSetting::class, 'id', 'time_setting_id');
    }
}
