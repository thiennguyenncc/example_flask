<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\Repository;

use Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Interfaces\UserInfoUpdatedTimeInterface;
use Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Models\UserInfoUpdatedTime as UserInfoUpdatedTimeDomainModel;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\ModelDao\UserInfoUpdatedTime;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 *
 */
class UserInfoUpdatedTimeRepository extends EloquentBaseRepository implements UserInfoUpdatedTimeInterface
{
    /**
     * EloquentUserInfoUpdatedTimeRepository constructor.
     * @param UserInfoUpdatedTime $model
     */
    public function __construct(UserInfoUpdatedTime $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return UserInfoUpdatedTimeDomainModel|null
     */
    public function getById(int $id): ?UserInfoUpdatedTimeDomainModel
    {
        $modelDao = $this->createQuery()->where('id', $id)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param UserInfoUpdatedTimeDomainModel $userInfoUpdatedTime
     * @return UserInfoUpdatedTimeDomainModel
     */
    public function save(UserInfoUpdatedTimeDomainModel $userInfoUpdatedTime): UserInfoUpdatedTimeDomainModel
    {
        return $this->createModelDAO($userInfoUpdatedTime->getId())->saveData($userInfoUpdatedTime);
    }

    /**
     * @param int $userId
     * @return UserInfoUpdatedTimeDomainModel|null
     */
    public function retrieveUserInfoUpdatedTimeByUserId(int $userId): ?UserInfoUpdatedTimeDomainModel
    {
        $modelDao = $this->createQuery()->where('user_id', $userId)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param UserInfoUpdatedTimeDomainModel $userInfoUpdatedTime
     * @return UserInfoUpdatedTimeDomainModel
     */
    public function getOnSameDayForTime(string $timeProperty, Carbon $date, ?array $with): Collection
    {
        $query = $this->createQuery()->whereDate($timeProperty, $date->toDateString());

        if ($with != null) {
            $query = $query->with($with);
        }

        return $this->transformCollection($query->get());
    }
}
