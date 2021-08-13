<?php

namespace Bachelor\Domain\Base\TimeSetting\Enums;

use Bachelor\Utility\Enums\StringEnum;

final class Cycles extends StringEnum
{
    const OneWeek = '1_week';
    const TwelveHours = '12_hour';
    const OneHour = '1_hour';
    const FifteenMinutes = '15_minute';
}
