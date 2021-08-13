<?php

namespace Bachelor\Domain\Base\Admin\Services\Interfaces;

use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\AdminActionLog;

interface AdminInterface
{
    /**
     * Admin action log
     *
     * @param array $context
     * @return AdminActionLog
     */
    public function actionLog(array $context) : AdminActionLog ;
}
