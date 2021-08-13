<?php

namespace Bachelor\Domain\UserManagement\UserPreference\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static BodyType()
 * @method static static MarriageIntention()
 * @method static static Character()
 * @method static static Smoking()
 * @method static static Drinking()
 * @method static static Divorce()
 * @method static static AnnualIncome()
 * @method static static AppearanceStrength()
 * @method static static AppearanceFeatures()
 * @method static static Education()
 * @method static static Job()
 * @method static static Hobby()
 * @method static static EducationGroup()
 */
final class UserPreference extends Enum
{
    const SecondPriority = 'important_preferences';
    const FirstPriority = 'important_preferences';
    const ThirdPriority = 'important_preferences';
    const FacePreferences = [
        'appearance_features',
        'appearance_strength',
    ];
    const PartnerBodyMax = 'preferred_body_shape';
    const PartnerBodyMin = 'preferred_body_shape';
    const AppearancePriority = 'preferred_importance_of_looks';
    const Education = 'preferred_education';
    const Smoking = 'preferred_smoke';
    const Drinking = 'preferred_drink';
    const Divorce = 'preferred_divorced';
    const AnnualIncome = 'preferred_annual_income';
    const Hobby = 'hobby';
    const Character = 'character';
    const job = 'preferred_job';
}
