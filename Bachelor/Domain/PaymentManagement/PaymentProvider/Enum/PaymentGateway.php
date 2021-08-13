<?php

namespace Bachelor\Domain\PaymentManagement\PaymentProvider\Enum;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static static Stripe()
 * @method static static ApplePay()
 */
final class PaymentGateway extends StringEnum
{
    const Stripe = 'stripe';
    const ApplePay = 'apple_pay';
}
