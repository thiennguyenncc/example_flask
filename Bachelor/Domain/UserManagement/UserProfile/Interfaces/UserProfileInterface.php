<?php

namespace Bachelor\Domain\UserManagement\UserProfile\Interfaces;

use Bachelor\Domain\UserManagement\UserProfile\Models\UserProfile as UserProfileDomainModel;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;
use Illuminate\Database\Eloquent\Builder;

/**
 *
 */
interface UserProfileInterface
{
    /**
     * @param int $id
     * @return UserProfileDomainModel|null
     */
    public function getById(int $id): ?UserProfileDomainModel;

    /**
     * @param int $userId
     * @param array $with|null
     * @return UserProfileDomainModel|null
     */
    public function retrieveUserProfileByUserId(int $userId, ?array $with = null): ?UserProfileDomainModel;

    /**
     * @param UserProfileDomainModel $userProfile
     * @return UserProfileDomainModel
     */
    public function save(UserProfileDomainModel $userProfile): UserProfileDomainModel;

}
