<?php

namespace Bachelor\Domain\AuthenticationManagement\Authentication\Enums;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static static Passport()
 */
final class OauthType extends StringEnum
{
    const Passport = 'passport';
}
