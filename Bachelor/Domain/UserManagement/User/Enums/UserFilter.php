<?php

namespace Bachelor\Domain\UserManagement\User\Enums;

use Bachelor\Utility\Enums\StringEnum;

final class UserFilter extends StringEnum
{
    // Add more filters here
    const Name = 'name';
    const Email = 'email';
    const Gender = 'gender';
    const Status = 'status';
    const RegistrationSteps = 'registration_steps';
    const PrefectureId = 'prefecture_id';
}
