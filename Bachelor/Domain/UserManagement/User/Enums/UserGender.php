<?php

namespace Bachelor\Domain\UserManagement\User\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static Male()
 * @method static static Female()
 */
final class UserGender extends IntEnum
{
    const Male = 1;
    const Female = 2;

    /**
     * Convert value to Srting
     *
     * @return string
     */
    public function toString() : string
    {
        return $this->value == self::Male ? 'male' : 'female';
    }
}
