<?php
namespace Bachelor\Port\Secondary\Database\DatingManagement\Matching\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\Matching\Interfaces\EloquentMatchingSettingInterface;
use Bachelor\Port\Secondary\Database\DatingManagement\Matching\ModelDao\MatchingSetting;

class EloquentMatchingSettingRepository extends EloquentBaseRepository implements EloquentMatchingSettingInterface
{

    /**
     * EloquentMatchingSettingRepository constructor.
     *
     * @param MatchingSetting $model
     */
    public function __construct(MatchingSetting $model)
    {
        parent::__construct($model);
    }
}