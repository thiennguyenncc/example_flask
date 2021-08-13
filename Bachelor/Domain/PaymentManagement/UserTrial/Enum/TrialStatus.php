<?php


namespace Bachelor\Domain\PaymentManagement\UserTrial\Enum;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static Active() User is currently in trial period
 * @method static static Completed() Trial period has completed
 * @method static static TempCancelled() This signifies when trial male user cancel date or is canceled by partner in the main matching and not be re-matched at 12pm on dating day.
 */
final class TrialStatus extends IntEnum
{
    const Active = 10;
    const TempCancelled = 20;
    const Completed = 30;
}
