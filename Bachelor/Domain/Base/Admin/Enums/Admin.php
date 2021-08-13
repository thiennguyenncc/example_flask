<?php

namespace Bachelor\Domain\Base\Admin\Enums;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Admin extends StringEnum
{
    const Admin = [
        'name' => 'Admin',
        'email' => 'admin@xvolve.com',
        'password' => '$2y$10$.69bq0m9pmt5KpCobb7LuuRS3Nc1m98OBWY0WGUasot3OPI2Rw1di', // Xvolve@123
        'referred_by' => null,
    ];
}
