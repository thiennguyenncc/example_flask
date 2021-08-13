<?php

namespace Bachelor\Domain\PaymentManagement\UserPlan\Enum;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static Scheduled()
 * @method static Active()
 * @method static Completed()
 * @method static Canceled()
 */
final class UserPlanStatus extends IntEnum
{
    const Scheduled = 10;
    const ScheduleCanceled = 19;
    const Active = 20;
    const Inactive = 99;
}
