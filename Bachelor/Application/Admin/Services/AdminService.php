<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Application\Admin\Services\Interfaces\AdminServiceInterface;
use Bachelor\Domain\Base\Admin\Services\Interfaces\AdminInterface;

class AdminService implements AdminServiceInterface
{
    /*
     * @var AdminInterface
     */
    private $admin;

    /**
     * AdminService constructor.
     * @param AdminInterface $admin
     */
    public function __construct (AdminInterface $admin)
    {
        $this->admin = $admin;
    }

    /**
     * Action log
     *
     * @param array $context
     * @return AdminServiceInterface
     */
    public function actionLog(array $context) : AdminServiceInterface
    {
        $this->admin->actionLog($context);

        return $this;
    }
}
