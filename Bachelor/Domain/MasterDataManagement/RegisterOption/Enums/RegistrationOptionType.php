<?php

namespace Bachelor\Domain\MasterDataManagement\RegisterOption\Enums;

use Bachelor\Utility\Enums\IntEnum;

class RegistrationOptionType extends IntEnum
{
    const AppearanceStrength = 'appearance_strength';
    const AppearanceFeatures = 'appearance_features';
    const StrengthsOfAppearance = 'strengths_of_appearance';
    const PreferredBodyShape = 'preferred_body_shape';
    const PreferredJob = 'preferred_job';
    const PreferredMaxAge = 'preferred_max_age';
    const PreferredMinAge = 'preferred_min_age';
    const PreferredMaxHeight = 'preferred_max_height';
    const PreferredMinHeight = 'preferred_min_height';
    const PreferredDivorced = 'preferred_divorced';
    const PreferredDrink = 'preferred_drink';
    const Job = 'job';
    const AnnualIncome = 'annual_income';
    const PreferredAnnualIncome = 'preferred_annual_income';
    const EducationGroup = 'education_group';
    const Education = 'education';
    const ProfileHeight = 'profile_height';
    const ProfileBodyType = 'profile_body_type';
    const Character = 'character';
    const Hobby = 'hobby';
    const Drinking = 'drinking';
    const Smoking = 'smoking';
    const Divorce = 'divorce';
    const MarriageIntention = 'marriage_intention';
    const PreferredImportanceOfLooks = 'preferred_importance_of_looks';
    const ImportantPreferences = 'important_preferences';
}
