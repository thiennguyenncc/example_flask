<?php

namespace Bachelor\Domain\DatingManagement\Matching\Enums;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static static TwelvePm()
 * @method static static ThreePm()
 */
final class RematchingType extends StringEnum
{
    const TwelvePm = '12pm';
    const ThreePm = '3pm';
}
