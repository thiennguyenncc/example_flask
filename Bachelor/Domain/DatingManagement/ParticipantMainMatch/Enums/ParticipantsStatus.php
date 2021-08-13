<?php

namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static Awaiting()
 * @method static static Unmatched()
 * @method static static Matched()
 * @method static static Cancelled()
 * @method static static Expired()
 */
final class ParticipantsStatus extends IntEnum
{
    const Awaiting = 10;
    const Unmatched = 20;
    const Matched = 30;
    const Cancelled = 40;
    const Expired = 50;
}
