<?php

namespace Bachelor\Domain\UserManagement\User\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static User()
 */
final class UserProperty extends IntEnum
{
    const Id  = 'id';
    const UserProfile  = 'userProfile';
    const UserPreference  = 'userPreference';
    const UserPreferredAreas  = 'userPreferredAreas';
    const Prefecture  = 'prefecture';
    const UserImages  = 'userImages';
}
