<?php

namespace Bachelor\Domain\UserManagement\User\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static FakeUser()
 * @method static static RealUser()
 */
final class EducationType extends IntEnum
{
    const Master = 1;
    const Bachelor = 2;
    const AssociateOrDiploma = 3;
    const HighSchoolGraduation = 4;
    const Other = 99;
}
