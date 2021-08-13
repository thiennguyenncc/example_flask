<?php

namespace Bachelor\Domain\NotificationManagement\Sms\Enums;

use Bachelor\Utility\Enums\IntEnum;

final class SmsStatus extends IntEnum
{
    const Processing =  1;
    const Success =  2;
    const Fail = 3;
}
