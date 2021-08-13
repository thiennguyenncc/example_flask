<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserPreference\Repository;

use Bachelor\Domain\UserManagement\UserPreference\Interfaces\UserPreferenceInterface;
use Bachelor\Domain\UserManagement\UserPreference\Models\UserPreference as UserPreferenceDomainModel;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreference\ModelDao\UserPreference;

/**
 * @TODO: implement UserRepositoryInterface instead
 */
class UserPreferenceRepository extends EloquentBaseRepository implements UserPreferenceInterface
{
    /**
     * EloquentUserProfileRepository constructor.
     * @param UserPreference $model
     */
    public function __construct(UserPreference $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return UserPreferenceDomainModel|null
     */
    public function getById(int $id): ?UserPreferenceDomainModel
    {
        $modelDao = $this->createQuery()->where('id', $id)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param UserPreferenceDomainModel $userProfile
     * @return UserPreferenceDomainModel
     */
    public function save(UserPreferenceDomainModel $userProfile): UserPreferenceDomainModel
    {
        return $this->createModelDAO($userProfile->getId())->saveData($userProfile);
    }

    /**
     * @param int $userId
     * @return UserPreferenceDomainModel|null
     */
    public function retrieveUserPreferenceByUserId(int $userId): ?UserPreferenceDomainModel
    {
        $modelDao = $this->createQuery()->where('user_id', $userId)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }
}
