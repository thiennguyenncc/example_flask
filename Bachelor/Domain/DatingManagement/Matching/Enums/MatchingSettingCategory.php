<?php
namespace Bachelor\Domain\DatingManagement\Matching\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 *
 * @method static static General()
 * @method static static TeamMemberRating()
 * @method static static TimingPoint()
 * @method static static StartingPoint()
 * @method static static PlanPoint()
 * @method static static ReviewPoint()
 * @method static static LastSatisfaction()
 * @method static static LastSatisfactionConverted()
 * @method static static BachelorCouponPoint()
 * @method static static SpecificAddonPoint()
 */
final class MatchingSettingCategory extends IntEnum
{

    const General = 1;

    const TeamMemberRating = 2;

    const TimingPoint = 3;

    const StartingPoint = 4;

    const PlanPoint = 5;

    const ReviewPoint = 6;

    const LastSatisfaction = 7;

    const LastSatisfactionConverted = 8;

    const BachelorCouponPoint = 9;

    const SpecificAddonPoint = 10;
    
    const ClosedPointBattle = 11;
}
 