<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\User\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserAccountMigrationLogInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAccountMigrationLog;

class EloquentUserAccountMigrationLogRepository extends EloquentBaseRepository implements EloquentUserAccountMigrationLogInterface
{
    /**
     * EloquentUserAccountMigrationLogRepository constructor.
     * @param UserAccountMigrationLog $userAccountMigrationLog
     */
    public function __construct(UserAccountMigrationLog $userAccountMigrationLog)
    {
        parent::__construct($userAccountMigrationLog);
    }
}
