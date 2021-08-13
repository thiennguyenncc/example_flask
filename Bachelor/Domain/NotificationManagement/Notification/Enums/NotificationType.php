<?php

namespace Bachelor\Domain\NotificationManagement\Notification\Enums;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static static Email()
 * @method static static Sms()
 */
final class NotificationType extends StringEnum
{
    const Email = 'email';
    const Sms = 'sms';
}
