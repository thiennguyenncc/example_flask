<?php

namespace Bachelor\Domain\PaymentManagement\Plan\Enum;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static NoDiscount()
 * @method static Young()
 *
 */
final class DiscountType extends StringEnum
{
    const NoDiscount = 'no_discount';
    const Young = 'young';
}
