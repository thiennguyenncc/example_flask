<?php

namespace Bachelor\Domain\AuthenticationManagement\Authentication\Enums;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static static User()
 * @method static static Admin()
 */

final class ClientType extends StringEnum
{
    const User = 'User';
    const Admin = 'Admin';
}
