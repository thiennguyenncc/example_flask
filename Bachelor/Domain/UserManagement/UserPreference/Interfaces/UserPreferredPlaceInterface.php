<?php

namespace Bachelor\Domain\UserManagement\UserPreference\Interfaces;

use Bachelor\Domain\UserManagement\UserPreference\Models\UserPreferredPlace as UserPreferredPlaceDomainModel;
use Illuminate\Support\Collection;

/**
 *
 */
interface UserPreferredPlaceInterface
{
    /**
     * @param int $id
     * @return UserPreferredPlaceDomainModel|null
     */
    public function getById(int $id): ?UserPreferredPlaceDomainModel;

    /**
     * @param int $userId
     * @param int $areaId
     * @return UserPreferredPlaceDomainModel|null
     */
    public function getByUserIdAndAreaId(int $userId, int $areaId): ?UserPreferredPlaceDomainModel;

    /**
     * @param int $userId
     * @return Collection|null
     */
    public function retrieveUserPreferredPlaceByUserId(int $userId): ?Collection;

    /**
     * @param UserPreferredPlaceDomainModel $userProfile
     * @return UserPreferredPlaceDomainModel
     */
    public function save(UserPreferredPlaceDomainModel $userProfile): UserPreferredPlaceDomainModel;

}
