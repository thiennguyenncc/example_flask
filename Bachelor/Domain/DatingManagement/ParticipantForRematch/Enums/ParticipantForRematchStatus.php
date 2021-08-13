<?php

namespace Bachelor\Domain\DatingManagement\ParticipantForRematch\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static Incompeleted()
 * @method static static Cancelled()
 * @method static static Completed()
 */
final class ParticipantForRematchStatus extends IntEnum
{
    const Awaiting = 10;
    const Unmatched = 20;
    const Matched = 30;
    const Cancelled = 40;
}
