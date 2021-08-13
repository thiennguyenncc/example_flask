<?php

namespace Bachelor\Domain\UserManagement\User\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static FakeUser()
 * @method static static RealUser()
 */
final class IsFake extends IntEnum
{
    const FakeUser = 1;
    const RealUser = 0;
}
