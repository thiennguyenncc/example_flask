<?php

namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums;

use Bachelor\Utility\Enums\StringEnum;

final class AvailableFrequencies extends StringEnum
{
    const All = 'all';
    const OncePerWeek = 'once_per_week';
    const OncePerThreeWeeks = 'once_per_three_weeks';
    const None = 'none';
}
