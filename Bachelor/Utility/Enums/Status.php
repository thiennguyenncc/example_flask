<?php

namespace Bachelor\Utility\Enums;

/**
 * @method static static Active()
 * @method static static Inactive()
 * @method static static Deleted()
 */
final class Status extends IntEnum
{
    const Inactive = 0;
    const Active = 1;
    const Deleted = 2;
}
