<?php
namespace Bachelor\Port\Secondary\Database\Base\TimeSetting\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Base\TimeSetting\ModelDao\TimeSetting;
use Bachelor\Port\Secondary\Database\Base\TimeSetting\Interfaces\EloquentTimeSettingInterface;

class EloquentTimeSettingRepository extends EloquentBaseRepository implements EloquentTimeSettingInterface
{

    /**
     * EloquentTimeSettingRepository constructor.
     *
     * @param TimeSetting $model
     */
    public function __construct(TimeSetting $model)
    {
        parent::__construct($model);
    }

    public function truncate()
    {
        return $this->model->truncate();
    }

    public function createTimeSettings(array $data)
    {
        $timeSettings = $this->model->firstOrNew($data);

        return $timeSettings->save();
    }
}
