<?php

namespace Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static Opened()
 * @method static static Closed()
 * @method static static Expired()
 */
final class ParticipationOpenExpireStatus extends IntEnum
{
    const Closed = 0;
    const Opened = 1;
    const Expired = 2;
}
