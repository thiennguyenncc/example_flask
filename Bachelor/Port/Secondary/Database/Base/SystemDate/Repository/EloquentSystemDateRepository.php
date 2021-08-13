<?php
namespace Bachelor\Port\Secondary\Database\Base\SystemDate\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Base\SystemDate\Interfaces\EloquentSystemDateInterface;
use Bachelor\Port\Secondary\Database\Base\SystemDate\ModelDao\SystemDate;

class EloquentSystemDateRepository extends EloquentBaseRepository implements EloquentSystemDateInterface
{
    /**
     * EloquentSystemDateRepository constructor.
     *
     * @param SystemDate $model
     */
    public function __construct(SystemDate $model)
    {
        parent::__construct($model);
    }
}
