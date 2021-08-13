<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Plan\Repository;

use Bachelor\Domain\PaymentManagement\UserPlan\Enum\UserPlanStatus;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Models\UserPlan;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\Plan\ModelDao\UserPlan as UserPlanDao;

class EloquentUserPlanRepository extends EloquentBaseRepository implements UserPlanRepositoryInterface
{
    /**
     * EloquentUserPlanRepository constructor.
     * @param UserPlanDao $model
     */
    public function __construct(UserPlanDao $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $value
     * @param string $column
     * @return UserPlan
     */
    public function getSpecificUserPlan($value, string $column = 'stripe_plan_id'): UserPlan
    {
        return $this->modelDAO->getSpecificData($value, $column)->first()->toDomainEntity();
    }

    /**
     * @param int $userId
     * @return UserPlan|null
     */
    public function getActiveUserPlanByUserId(int $userId): ?UserPlan
    {
        $userPlan = $this->model
            ->where('user_id', $userId)
            ->where('status', UserPlanStatus::Active)
            ->first();

        return optional($userPlan)->toDomainEntity();
    }

    /**
     * @param int $userId
     * @return UserPlan
     */
    public function getScheduledUserPlanByUserId(int $userId): ?UserPlan
    {
        $userPlan = $this->model
            ->where('user_id', $userId)
            ->where('status', UserPlanStatus::Scheduled)
            ->first();

        return optional($userPlan)->toDomainEntity();
    }

    /**
     * Create new user plan
     *
     * @param UserPlan $userPlan
     * @return mixed
     */
    public function save(UserPlan $userPlan): UserPlan
    {
        return $this->createModelDAO($userPlan->getId())->saveData($userPlan);
    }
}
