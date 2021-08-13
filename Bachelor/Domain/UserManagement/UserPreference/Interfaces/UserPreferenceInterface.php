<?php

namespace Bachelor\Domain\UserManagement\UserPreference\Interfaces;

use Bachelor\Domain\UserManagement\UserPreference\Models\UserPreference as UserPreferenceDomainModel;

/**
 *
 */
interface UserPreferenceInterface
{
    /**
     * @param int $id
     * @return UserPreferenceDomainModel|null
     */
    public function getById(int $id): ?UserPreferenceDomainModel;

    /**
     * @param int $userId
     * @return UserPreferenceDomainModel|null
     */
    public function retrieveUserPreferenceByUserId(int $userId): ?UserPreferenceDomainModel;

    /**
     * @param UserPreferenceDomainModel $userProfile
     * @return UserPreferenceDomainModel
     */
    public function save(UserPreferenceDomainModel $userProfile): UserPreferenceDomainModel;

}
