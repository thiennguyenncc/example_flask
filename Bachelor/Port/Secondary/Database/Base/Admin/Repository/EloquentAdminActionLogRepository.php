<?php

namespace Bachelor\Port\Secondary\Database\Base\Admin\Repository;

use Bachelor\Port\Secondary\Database\Base\Admin\Interfaces\EloquentAdminActionLogInterface;
use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\AdminActionLog;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;

class EloquentAdminActionLogRepository extends EloquentBaseRepository implements EloquentAdminActionLogInterface
{
    /**
     * EloquentUserAccountMigrationLogRepository constructor.
     * @param AdminActionLog $adminActionLog
     */
    public function __construct(AdminActionLog $adminActionLog)
    {
        parent::__construct($adminActionLog);
    }

}
