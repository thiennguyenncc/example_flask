<?php

namespace Bachelor\Domain\UserManagement\User\Traits;

use Bachelor\Domain\MasterDataManagement\School\Enums\EducationGroup;
use Bachelor\Domain\PrefectureManagement\DatingPlace\Model\DatingPlace;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserPreference\Models\UserPreference;
use Bachelor\Domain\UserManagement\UserProfile\Enums\UserProfile as EnumsUserProfile;
use Bachelor\Domain\UserManagement\UserProfile\Models\UserProfile;
use stdClass;

trait MatchProfileFormatter
{
    /**
     * Get matched preference
     *
     * @param int $userPriority
     * @param User $user
     * @param UserProfile $partnerProfile
     * @return bool|string
     */
    protected function getMatchedPreference(int $userPriority, User $user, UserPreference $userPreference, UserProfile $partnerProfile)
    {
        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        switch ($userPriority) {
            case 0:
                return $this->checkAgePreference($userPreference, $partnerProfile);
            case 1:
                return $this->checkHeightPreference($userPreference, $partnerProfile);
            case 3:
                return $this->checkBodyShapePreference($user, $userPreference, $partnerProfile);
            case 4:
                return $this->checkSmokePreference($userPreference, $partnerProfile);
            case 5:
                return $this->checkDrinkPreference($userPreference, $partnerProfile);
            case 6:
                return $this->checkDivorcePreference($partnerProfile);
            case 8:
                return $this->checkMarriagePreference($userProfile, $partnerProfile);
            case 9:
                return $this->checkEducationPreference($partnerProfile);
            case 10:
                return $this->checkIncomePreference($user, $userPreference, $partnerProfile);
            case 12:
                return $this->checkFaceAppearancePreference($userPreference, $partnerProfile);
            case 13:
                return $this->checkHobbyPreference($userPreference, $partnerProfile);
            default:
                return false;
        }
    }

    /**
     * Check age preference
     *
     * @param UserPreference $userPreference
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkAgePreference(UserPreference $userPreference, UserProfile $partnerProfile)
    {
        $partnerAge = $partnerProfile->getAge();
        if (
            $userPreference->getAgeFrom() <= $partnerAge
            && $partnerAge <= $userPreference->getAgeTo()
        ) {
            return [
                'key' => 'age_is',
                'data' => ['age' => $partnerAge]
            ];
        }
        return false;
    }

    /**
     * Height preference
     *
     * @param User $user
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkHeightPreference(UserPreference $userPreference, UserProfile $partnerProfile)
    {
        $partnerHeight = $partnerProfile->getHeight();
        if (
            $userPreference->getHeightFrom() <= $partnerHeight
            && $partnerHeight <= $userPreference->getHeightTo()
        ) {
            return [
                'key' => 'height_is',
                'data' => ['height' => $partnerProfile->getHeight()]
            ];
        }
        return false;
    }

    /**
     * Shape preference
     *
     * @param UserPreference $userPreference
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkBodyShapePreference(User $user, UserPreference $userPreference, UserProfile $partnerProfile)
    {
        $partnerBodyType = $partnerProfile->getBodyType();
        $partnerBodyTypeText = $this->registerOption->getRegisterOptionDisplayName(
            $partnerBodyType,
            EnumsUserProfile::PartnerBodyType,
            $user->getGender() === UserGender::Male ? UserGender::Female : UserGender::Male
        );
        if (
            $userPreference->getPartnerBodyMin() <= $partnerBodyType
            && $partnerBodyType <= $userPreference->getPartnerBodyMax()
        ) {
            return [
                'key' => 'body_shape_is',
                'data' => ['body_shape' => $partnerBodyTypeText]
            ];
        }
        return false;
    }

    /**
     * Smoke preference
     *
     * @param UserPreference $userPreference
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkSmokePreference(UserPreference $userPreference, UserProfile $partnerProfile)
    {
        $partnerSmoking =  $partnerProfile->getSmoking();
        $partnerSmokingText = $this->registerOption->getRegisterOptionDisplayName(
            $partnerSmoking,
            EnumsUserProfile::Smoking
        );;
        if (in_array($userPreference->getSmoking(), [2, 3]) && $partnerSmoking === 1) {
            return [
                'key' => 'dont_smoke',
                'data' => ['smoking' => $partnerSmokingText]
            ];
        }
        return false;
    }

    /**
     * Get drinking preference
     *
     * @param UserPreference $userPreference
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkDrinkPreference(UserPreference $userPreference, UserProfile $partnerProfile)
    {
        $userDrinking = $userPreference->getDrinking();
        $partnerDrinking = $partnerProfile->getDrinking();
        $partnerDrinkingText = $this->registerOption->getRegisterOptionDisplayName(
            $partnerDrinking,
            EnumsUserProfile::Drinking
        );;
        if (
            ($userDrinking === 1 && in_array($partnerDrinking, [1, 3]))
            || ($userDrinking === 2 && in_array($partnerDrinking, [2, 3]))
            || ($userDrinking === 3 && ($partnerDrinking === 2))
        ) {
            return [
                'key' => 'alcohol_preference_is',
                'data' => ['drink' => $partnerDrinkingText]
            ];
        }
        return false;
    }

    /**
     * Divorce preference
     *
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkDivorcePreference(UserProfile $partnerProfile)
    {
        if ($partnerProfile->getDivorce() === 1) {
            return [
                'key' => 'no_history_divorce',
                'data' => []
            ];
        }
        return false;
    }

    /**
     * Marriage Preference
     *
     * @param UserProfile $userProfile
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkMarriagePreference(UserProfile $userProfile, UserProfile $partnerProfile)
    {
        $partnerMarriageIntention = $partnerProfile->getMarriageIntention();
        $partnerMarriageIntentionText = $this->registerOption->getRegisterOptionDisplayName(
            $partnerMarriageIntention,
            EnumsUserProfile::MarriageIntention
        );;
        if ($userProfile->getMarriageIntention() === $partnerMarriageIntention) {
            return [
                'key' => 'marriage_intention_preference_is',
                'data' => ['merriage' => $partnerMarriageIntentionText]
            ];
        }
        return false;
    }

    /**
     * Education preference
     *
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkEducationPreference(UserProfile $partnerProfile)
    {
        if ($partnerProfile->getSchool()?->getEducationGroup() >= EducationGroup::FamousUniv)
            return [
                'key' => 'educational_background_is_highly_educated',
                'data' => [],
            ];
        elseif ($partnerProfile->getSchool()?->getEducationGroup() >= EducationGroup::MediumStandardUniv)
            return [
                'key' => 'educational_background_is_medium_standard_uni',
                'data' => [],
            ];
        return false;
    }

    /**
     * Income preference
     *
     * @param User $user
     * @param UserPreference $userPreference
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkIncomePreference(User $user, UserPreference $userPreference, UserProfile $partnerProfile)
    {
        $partnerAnnualIncome = $partnerProfile->getAnnualIncome();
        $partnerAnnualIncomeText = $this->registerOption->getRegisterOptionDisplayName(
            $partnerAnnualIncome,
            EnumsUserProfile::AnnualIncome
        );;
        if (
            $user->getGender() === UserGender::Female
            && $userPreference->getAnnualIncome() <= $partnerAnnualIncome
        ) {
            return [
                'key' => 'annual_income_is',
                'data' => ['partnerIncome' => $partnerAnnualIncomeText]
            ];
        }
        return false;
    }

    /**
     * Face appearance preference
     *
     * @param UserPreference $userPreference
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkFaceAppearancePreference(UserPreference $userPreference, UserProfile $partnerProfile)
    {
        $userFacePreferences = $userPreference->getFacePreferences();

        $matchedAppearanceFeatures = array_intersect(
            $userFacePreferences,
            $partnerProfile->getAppearanceFeatures()
        );

        $matchedAppearanceStrength = array_intersect(
            $userFacePreferences,
            $partnerProfile->getAppearanceStrength()
        );

        $matchedAppearanceFeaturesText = $this->registerOption->getRegisterOptionDisplayNames(
            $matchedAppearanceFeatures,
            EnumsUserProfile::AppearanceFeatures
        );

        $matchedAppearanceStrengthText = $this->registerOption->getRegisterOptionDisplayNames(
            $matchedAppearanceStrength,
            EnumsUserProfile::AppearanceStrength
        );

        $matchedPreferences = array_merge($matchedAppearanceFeaturesText, $matchedAppearanceStrengthText);

        if (!empty($matchedPreferences)) {
            return [
                'key' => 'face_preference_is',
                'data' => ['face_preference' => implode(", ", $matchedPreferences)]
            ];
        }

        return false;
    }

    /**
     * Hobby preference
     *
     * @param UserPreference $userPreference
     * @param UserProfile $partnerProfile
     * @return array|bool|string|null
     */
    protected function checkHobbyPreference(UserPreference $userPreference, UserProfile $partnerProfile)
    {
        $userHobbyPreference = (array) $userPreference->getHobby();
        $partnerHobby = $partnerProfile->getHobby();

        $matchedHobby = array_intersect($userHobbyPreference, $partnerHobby);

        $matchedHobbyText = $this->registerOption->getRegisterOptionDisplayNames(
            $matchedHobby,
            EnumsUserProfile::Hobby
        );

        if (!empty($matchedHobby)) {
            return [
                'key' => 'hobby_preference_is',
                'data' => ['hobby' => implode(",", $matchedHobbyText)]
            ];
        }
        return false;
    }
}
