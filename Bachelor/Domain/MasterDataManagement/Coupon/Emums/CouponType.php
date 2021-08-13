<?php

namespace Bachelor\Domain\MasterDataManagement\Coupon\Emums;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static static Dating()
 * @method static static Bachelor()
 */
final class CouponType  extends StringEnum
{
    const Dating = 'dating';
    const Bachelor = 'bachelor';
}
