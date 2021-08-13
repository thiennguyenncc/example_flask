<?php

namespace Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Interfaces;

use Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Models\UserInfoUpdatedTime as UserInfoUpdatedTimeDomainModel;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 *
 */
interface UserInfoUpdatedTimeInterface
{
    /**
     * @param int $id
     * @return UserInfoUpdatedTimeDomainModel|null
     */
    public function getById(int $id): ?UserInfoUpdatedTimeDomainModel;

    /**
     * @param int $userId
     * @return UserInfoUpdatedTimeDomainModel|null
     */
    public function retrieveUserInfoUpdatedTimeByUserId(int $userId): ?UserInfoUpdatedTimeDomainModel;

    /**
     * @param UserInfoUpdatedTimeDomainModel $userInfoUpdatedTime
     * @return UserInfoUpdatedTimeDomainModel
     */
    public function save(UserInfoUpdatedTimeDomainModel $userInfoUpdatedTime): UserInfoUpdatedTimeDomainModel;

    /**
     * @param UserInfoUpdatedTimeDomainModel $userInfoUpdatedTime
     * @return UserInfoUpdatedTimeDomainModel
     */
    public function getOnSameDayForTime(string $timeProperty, Carbon $date, ?array $with): Collection;

}