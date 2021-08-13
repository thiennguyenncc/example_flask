<?php

namespace Bachelor\Domain\NotificationManagement\Email\Enums;

use Bachelor\Utility\Enums\IntEnum;

final class EmailStatus extends IntEnum
{
    const Processing =  1;
    const Success =  2;
    const Fail = 3;
}
