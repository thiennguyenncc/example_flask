<?php
namespace Bachelor\Port\Secondary\Database\Base\SystemCronTime\Traits;

use Bachelor\Port\Secondary\Database\Base\TimeSetting\ModelDao\TimeSetting;

trait SystemCronTimeRelationshipTrait
{

    /**
     * Get time cycle settings
     */
    public function time_setting()
    {
        return $this->hasOne(TimeSetting::class, 'id', 'time_setting_id');
    }
}
