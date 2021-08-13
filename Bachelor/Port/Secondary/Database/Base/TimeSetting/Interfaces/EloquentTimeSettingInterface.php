<?php

namespace Bachelor\Port\Secondary\Database\Base\TimeSetting\Interfaces;

interface EloquentTimeSettingInterface
{
    /**
     * Create time settings table
     *
     * @param array $data
     * @return mixed
     */
    public function createTimeSettings(array $data);
}
