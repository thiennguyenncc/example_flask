<?php

namespace Bachelor\Domain\UserManagement\UserCoupon\Enum;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static Used() Signifies the coupon that has been used by the user
 * @method static static Unused() Signifies when the coupon is given to the user and the user hasn't used it yet
 * @method static static Exchanged() Signifies that these coupon has been exchanged
 * @method static static Expired() Signifies that the coupon time period has expired
 */
final class UserCouponStatus extends IntEnum
{
    const Used = 1;
    const Unused = 2;
    const Exchanged = 4;
    const Expired = 5;
}
