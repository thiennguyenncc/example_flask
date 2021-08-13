<?php

namespace Bachelor\Domain\PaymentManagement\UserPlan\Interfaces;

use Bachelor\Domain\PaymentManagement\UserPlan\Models\UserPlan;
use Bachelor\Domain\UserManagement\User\Models\User;

interface UserPlanRepositoryInterface
{
    /**
     * @param $value
     * @param string $column
     * @return UserPlan
     */
    public function getSpecificUserPlan($value, string $column = 'plan_id'): UserPlan;

    /**
     * @param int $userId
     * @return UserPlan|null
     */
    public function getActiveUserPlanByUserId(int $userId): ?UserPlan;

    /**
     * @param int $userId
     * @return UserPlan|null
     */
    public function getScheduledUserPlanByUserId(int $userId): ?UserPlan;

    /**
     * Create new user plan
     *
     * @param UserPlan $plan
     * @return UserPlan
     */
    public function save(UserPlan $userPlan): UserPlan;
}
