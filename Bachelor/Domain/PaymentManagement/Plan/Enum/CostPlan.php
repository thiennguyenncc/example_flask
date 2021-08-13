<?php

namespace Bachelor\Domain\PaymentManagement\Plan\Enum;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static static Light()
 * @method static static Normal()
 * @method static static Premium()
 */
final class CostPlan extends StringEnum
{
    const Light = 'light';
    const Normal = 'normal';
    const Premium = 'premium';
}
