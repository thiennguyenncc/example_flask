<?php

namespace Bachelor\Domain\NotificationManagement\Notification\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static Inactive()
 * @method static static Active()
 */
final class NotificationStatus extends IntEnum
{
    const Inactive =  0;
    const Active =  1;
}
