<?php

namespace Bachelor\Application\Admin\Services\Interfaces;

interface AdminServiceInterface
{
    /**
     * Action logs
     *
     * @param array $context
     * @return AdminServiceInterface
     */
    public function actionLog(array $context) : AdminServiceInterface ;
}
