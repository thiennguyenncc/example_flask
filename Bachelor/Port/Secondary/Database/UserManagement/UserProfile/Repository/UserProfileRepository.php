<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserProfile\Repository;

use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;
use Bachelor\Domain\UserManagement\UserProfile\Models\UserProfile as UserProfileDomainModel;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;

/**
 *
 */
class UserProfileRepository extends EloquentBaseRepository implements UserProfileInterface
{
    /**
     * EloquentUserProfileRepository constructor.
     * @param UserProfile $model
     */
    public function __construct(UserProfile $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return UserProfileDomainModel|null
     */
    public function getById(int $id): ?UserProfileDomainModel
    {
        $modelDao = $this->createQuery()->where('id', $id)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param UserProfileDomainModel $userProfile
     * @return UserProfileDomainModel
     */
    public function save(UserProfileDomainModel $userProfile): UserProfileDomainModel
    {
        return $this->createModelDAO($userProfile->getId())->saveData($userProfile);
    }

    /**
     * @param int $userId
     * @param array $with|null
     * @return UserProfileDomainModel|null
     */
    public function retrieveUserProfileByUserId(int $userId, ?array $with = null): ?UserProfileDomainModel
    {
        $query = $this->createQuery()->where('user_id', $userId);

        if ($with != null) {
            $query = $query->with($with);
        }

        $modelDao = $query->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }
}
