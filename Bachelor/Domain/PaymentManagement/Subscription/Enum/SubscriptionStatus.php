<?php

namespace Bachelor\Domain\PaymentManagement\Subscription\Enum;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static Active()
 * @method static Canceled()
 * @method static Incomplete()
 * @method static IncompleteExpired()
 * @method static PastDue()
 *  For status reference https://stripe.com/docs/api/subscriptions/object
 */
final class SubscriptionStatus extends StringEnum
{
    const Active = 'active';
    const Canceled = 'canceled';
    const Incomplete = 'incomplete';
    const IncompleteExpired = 'incomplete_expired';
    const PastDue = 'past_due';
}
