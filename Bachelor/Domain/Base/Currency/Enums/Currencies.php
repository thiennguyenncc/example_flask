<?php

namespace Bachelor\Domain\Base\Currency\Enums;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static static Dollars()
 * @method static static JapaneseYen()
 */
final class Currencies extends StringEnum
{
    const Dollars = '$';
    const JapaneseYen = '¥';
}
