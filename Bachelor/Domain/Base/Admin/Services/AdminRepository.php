<?php

namespace Bachelor\Domain\Base\Admin\Services;

use Bachelor\Domain\Base\Admin\Services\Interfaces\AdminInterface;
use Bachelor\Domain\Base\Admin\Traits\AdminActionLogFormatter;
use Bachelor\Port\Secondary\Database\Base\Admin\Interfaces\EloquentAdminActionLogInterface;
use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\AdminActionLog;

class AdminRepository implements AdminInterface
{
    use AdminActionLogFormatter;

    /*
     * @var EloquentAdminActionLogInterface
     */
    private $adminActionLogRepository;

    /**
     * AdminRepository constructor.
     * @param EloquentAdminActionLogInterface $adminActionLogRepository
     */
    public function __construct (EloquentAdminActionLogInterface $adminActionLogRepository)
    {
        $this->adminActionLogRepository = $adminActionLogRepository;
    }

    /**
     * Admin action log
     *
     * @param array $context
     * @return AdminActionLog
     */
    public function actionLog(array $context) : AdminActionLog
    {
        return $this->adminActionLogRepository->create(self::adminActionLogFormatter($context));
    }
}
