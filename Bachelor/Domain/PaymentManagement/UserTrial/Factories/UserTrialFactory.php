<?php

namespace Bachelor\Domain\PaymentManagement\UserTrial\Factories;

use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Models\UserTrial;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;

class UserTrialFactory
{
    /**
     * @param int $userId
     * @param Carbon $trialStart
     * @param Carbon $trialEnd
     * @param int $status
     * @return UserTrial
     */
    public function createUserTrial(User $user, Carbon $trialStart, Carbon $trialEnd, int $status = TrialStatus::Active): UserTrial
    {
        return new UserTrial($user->getId(), $trialStart, $trialEnd, $status);
    }
}
