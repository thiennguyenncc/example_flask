<?php

namespace Bachelor\Domain\Base\TimeSetting\Enums;

use Bachelor\Utility\Enums\StringEnum;

final class TimeKeys extends StringEnum
{
    const WeekStart = 'week_start';
    const WeekEnd = 'week_end';
    const RenewCycle = 'renew_cycle';
}
