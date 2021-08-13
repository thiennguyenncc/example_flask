<?php

namespace Bachelor\Domain\UserManagement\UserCoupon\Enum;

use BenSampo\Enum\Enum;

/**
 * @method static static Issued()
 * @method static static Purchased()
 */
final class UserCouponCategory extends Enum
{
    const Issued = [
        'id' => 1,
        'name' => 'issued',
        'validity' => 2
    ];
    const Purchased = [
        'id' => 2,
        'name' => 'purchased',
        'validity' => 6
    ];
}
