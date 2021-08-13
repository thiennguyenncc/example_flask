<?php

namespace Bachelor\Domain\UserManagement\UserPreference\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static AgeToForPremium()
 */
final class ValidationMessages extends Enum
{
    const AgeToForPremium = [
        'age_to' => ['プレミアムプラン限定']
    ];
}
