<?php

namespace Bachelor\Domain\DatingManagement\Dating\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static Incompleted()
 * @method static static Cancelled()
 * @method static static Completed()
 */
final class DatingStatus extends IntEnum
{
    const Incompleted = 1;
    const Cancelled = 2;
    const Completed = 3;
}
