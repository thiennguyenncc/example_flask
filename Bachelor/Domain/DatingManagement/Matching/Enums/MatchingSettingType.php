<?php
namespace Bachelor\Domain\DatingManagement\Matching\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 *
 * @method static static PriorityPoint()
 * @method static static OverallPoint()
 */
final class MatchingSettingType extends IntEnum
{

    const PriorityPoint = 1;

    const OverallPoint = 2;
    
    const ClosedPointBattle = 3;
}
