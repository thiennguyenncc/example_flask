<?php

namespace Bachelor\Domain\UserManagement\UserPreferredArea\Models;


use Bachelor\Domain\Base\BaseDomainModel;

class UserPreferredArea extends BaseDomainModel
{
    /*
     * @var int
     */
    private int $userId;

    /*
     * @var int
     */
    private int $areaId;

    /*
     * @var int
     */
    private int $priority;

    /**
     * UserPreferredArea constructor.
     * @param int $userId
     * @param int $areaId
     * @param int $priority
     */
    public function __construct (int $userId, int $areaId, int $priority)
    {
        $this->setUserId($userId);
        $this->setAreaId($areaId);
        $this->setPriority($priority);
    }

    /**
     * @return int
     */
    public function getPriority (): int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority ( int $priority ): void
    {
        $this->priority = $priority;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getAreaId(): int
    {
        return $this->areaId;
    }

    /**
     * @param int $areaId
     */
    public function setAreaId(int $areaId): void
    {
        $this->areaId = $areaId;
    }

}
