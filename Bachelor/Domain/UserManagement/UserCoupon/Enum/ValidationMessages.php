<?php

namespace Bachelor\Domain\UserManagement\UserCoupon\Enum;

use BenSampo\Enum\Enum;

/**
 * @method static TrialMaleUserCantUseCoupon()
 */
final class ValidationMessages extends Enum
{
    const TrialMaleUserCantUseCoupon = [
        'trial_male_user_cant_use_coupon' => ['無料期間中はチケットを利用できません']
    ];
    const NoAvailableCoupon = [
        'no_available_coupon' => ['利用可能なチケットを所持していません']
    ];
    const NotHaveEnoughCouponToExchange = [
        'not_have_enough_coupon_to_exchange' => ['チケット枚数が足りません']
    ];
}
