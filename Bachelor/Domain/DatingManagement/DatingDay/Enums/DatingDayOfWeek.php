<?php

namespace Bachelor\Domain\DatingManagement\DatingDay\Enums;

use Bachelor\Utility\Enums\StringEnum;

use function Complex\sec;

/**
 * @method static Monday()
 * @method static Tuesday()
 * @method static Wednesday()
 * @method static ThursDay()
 * @method static Friday()
 * @method static Saturday()
 * @method static Sunday()
 */
final class DatingDayOfWeek extends StringEnum
{
    const Monday = 'monday';
    const Tuesday = 'tuesday';
    const Wednesday = 'wednesday';
    const ThursDay = 'thursDay';
    const Friday = 'friday';
    const Saturday = 'saturday';
    const Sunday = 'sunday';

    public static function getMatchingDayOfWeek()
    {
        return [
            self::Wednesday,
            self::Saturday,
            self::Sunday,
        ];
    }
}
