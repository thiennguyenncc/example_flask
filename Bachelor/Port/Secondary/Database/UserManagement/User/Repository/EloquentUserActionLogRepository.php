<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\User\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserActionLogInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserActionLog;

class EloquentUserActionLogRepository extends EloquentBaseRepository implements EloquentUserActionLogInterface
{
    /**
     * EloquentUserAccountMigrationLogRepository constructor.
     * @param UserActionLog $userActionLog
     */
    public function __construct(UserActionLog $userActionLog)
    {
        parent::__construct($userActionLog);
    }
}
