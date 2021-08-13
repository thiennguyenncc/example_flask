<?php


namespace Bachelor\Port\Secondary\Database\UserManagement\User\Repository;


use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentCancelDeactivateFormInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\CancelDeactivateForm;

class EloquentCancelDeactivateFormRepository extends EloquentBaseRepository implements EloquentCancelDeactivateFormInterface
{
    /**
     * EloquentUserAccountMigrationLogRepository constructor.
     * @param CancelDeactivateForm $cancelDeactivateForm
     */
    public function __construct(CancelDeactivateForm $cancelDeactivateForm)
    {
        parent::__construct($cancelDeactivateForm);
    }
}
