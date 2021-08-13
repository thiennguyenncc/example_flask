<?php

namespace Bachelor\Domain\UserManagement\UserPreferredArea\Interfaces;

use Bachelor\Domain\UserManagement\UserPreferredArea\Models\UserPreferredArea as UserPreferredAreaDomainModel;
use Illuminate\Support\Collection;

interface UserPreferredAreasInterface
{
    /**
     * @param int $id
     * @return UserPreferredAreaDomainModel|null
     */
    public function getById(int $id): ?UserPreferredAreaDomainModel;

    /**
     * @param int $userId
     * @param int $areaId
     * @return UserPreferredAreaDomainModel|null
     */
    public function getByUserIdAndAreaId(int $userId, int $areaId): ?UserPreferredAreaDomainModel;

    /**
     * @param int $userId
     * @return Collection|null
     */
    public function retrieveUserPreferredPlaceByUserId(int $userId): ?Collection;

    /**
     * @param UserPreferredAreaDomainModel $userPreferredPlace
     * @return UserPreferredAreaDomainModel
     */
    public function save(UserPreferredAreaDomainModel $userPreferredPlace): UserPreferredAreaDomainModel;
}
