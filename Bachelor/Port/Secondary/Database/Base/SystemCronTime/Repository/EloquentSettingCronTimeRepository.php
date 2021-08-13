<?php
namespace Bachelor\Port\Secondary\Database\Base\SystemCronTime\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Base\SystemCronTime\ModelDao\SettingCronTime;

class EloquentSettingCronTimeRepository extends EloquentBaseRepository
{
    /**
     * EloquentSettingCronTimeRepository constructor.
     *
     * @param SettingCronTime $model
     */
    public function __construct(SettingCronTime $model)
    {
        parent::__construct($model);
    }

    public function truncate()
    {
        return $this->model->truncate();
    }

    public function createTimeSettings(array $data)
    {
        $settingCronTime = $this->model->firstOrNew($data);

        return $settingCronTime->save();
    }
}
