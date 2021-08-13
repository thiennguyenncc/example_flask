<?php

namespace Bachelor\Port\Secondary\Database\Base\Admin\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\Admin;
use Bachelor\Port\Secondary\Database\Base\Admin\Interfaces\EloquentAdminInterface;

class EloquentAdminRepository extends EloquentBaseRepository implements EloquentAdminInterface
{
    /**
     * EloquentAdminRepository constructor.
     * @param Admin $model
     */
    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }
}
