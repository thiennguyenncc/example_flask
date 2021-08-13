<?php
namespace Bachelor\Application\Admin\Services\Interfaces;

interface AdminTimeSettingServiceInterface
{

    /**
     * Create new cycle
     *
     * @param array $params
     * @return AdminTimeSettingServiceInterface
     */
    public function createNewCycle(array $params): AdminTimeSettingServiceInterface;

    /**
     * Renew existing cycle to next week
     *
     * @return AdminTimeSettingServiceInterface
     */
    public function renewTimecycle(): AdminTimeSettingServiceInterface;
}
