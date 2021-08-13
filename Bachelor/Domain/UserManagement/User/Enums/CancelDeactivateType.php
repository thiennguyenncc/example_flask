<?php

namespace Bachelor\Domain\UserManagement\User\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static Cancel()
 * @method static static Deactivate()
 */

final class CancelDeactivateType extends IntEnum
{
    const Cancel = 1;
    const Deactivate = 2;
}
