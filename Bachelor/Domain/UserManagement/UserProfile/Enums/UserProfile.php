<?php

namespace Bachelor\Domain\UserManagement\UserProfile\Enums;

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
final class UserProfile extends Enum
{
    const BodyType = 'body_type';
    const ProfileBodyType = 'profile_body_type';
    const PartnerBodyType = 'partner_body_type';
    const MarriageIntention = 'marriage_intention';
    const Character = 'character';
    const Smoking = 'smoking';
    const Drinking = 'drinking';
    const Divorce = 'divorce';
    const AnnualIncome = 'annual_income';
    const AppearanceStrength = 'appearance_strength';
    const AppearanceFeatures = 'appearance_features';
    const Education = 'education';
    const Job = 'job';
    const Hobby = 'hobby';
    const EducationGroup = 'education_group';
    const User = 'user';
}
