<?php

namespace Bachelor\Domain\UserManagement\User\Traits;

use Bachelor\Domain\MasterDataManagement\Area\Model\Area;
use Bachelor\Domain\MasterDataManagement\Prefecture\Model\Prefecture;
use Bachelor\Domain\MasterDataManagement\RegisterOption\Model\RegisterOption;
use Bachelor\Domain\MasterDataManagement\RegisterOption\Model\RegisterOptionTranslation;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserInvitation\Models\UserInvitation;
use Bachelor\Domain\UserManagement\UserPreference\Models\UserPreference;
use Bachelor\Domain\UserManagement\UserPreferredArea\Models\UserPreferredArea;
use Bachelor\Domain\UserManagement\UserProfile\Models\UserImage;
use Bachelor\Domain\UserManagement\UserProfile\Models\UserProfile;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

trait RegistrationDataExtractorTrait
{

    /**
     * @param Prefecture $prefecture
     * @return array
     */
    public function formatPrefectureData(?Prefecture $prefecture): array
    {
        $data = [];
        if (!$prefecture) {
            return [];
        }
        $data['name'] = $prefecture->getName();
        $data['id'] = $prefecture->getId();
        $data['country_id'] = $prefecture->getCountryId();
        $data['area'] = [];
        $areas = $this->areaRepository->getAreasByPrefectureId($prefecture->getId());
        foreach ($areas as $area) {
            $data['area'][] = $this->formatAreaData($area);
        }

        return $data;
    }

    /**
     * @param Collection|null $areas
     * @return array
     */
    public function formatAreasData(?Collection $areas): array
    {
        $data = [];
        if (!$areas) {
            return [];
        }foreach ($areas as $area) {
            $data[] = $this->formatAreaData($area);
        }
        return $data;
    }

    /**
     * @param Area $area
     * @return array
     */
    public function formatAreaData(Area $area): array
    {
        $data['name'] = $area->getName();
        $data['id'] = $area->getId();
        if ($area->getAreaTranslation()) {
            $data['name'] = $area->getAreaTranslation()->getName();
        }
        $data['image'] = $area->getImage();
        return $data;
    }

    /**
     * @param ?Collection $userImages
     * @return array
     */
    public function formatUserPreferredAreasCollectionData(?Collection $userImages): array
    {
        $data = [];
        foreach ($userImages as $userImage) {
            $data[] = $this->formatUserPreferredAreaData($userImage);
        }
        return $data;
    }

    /**
     * @param UserPreferredArea $userPreferredArea
     * @return array
     */
    public function formatUserPreferredAreaData(UserPreferredArea $userPreferredArea): array
    {
        $data['area_id'] = $userPreferredArea->getAreaId();
        $data['priority'] = $userPreferredArea->getPriority();
        return $data;
    }

    /**
     * @param ?Collection $userImages
     * @return array
     */
    public function formatUserImageCollectionData(?Collection $userImages): array
    {
        $data = [];
        foreach ($userImages as $userImage) {
            $data[] = $this->formatUserImageData($userImage);
        }
        return $data;
    }

    /**
     * @param UserImage $userImage
     * @return array
     */
    public function formatUserImageData(UserImage $userImage): array
    {
        $data['file_name'] = $userImage->getFileName();
        $data['url'] = Utility::getFileLink($userImage->getFileName(), config('constants.user_profile_storage_path'));
        $data['is_primary'] = $userImage->getIsPrimary();
        return $data;
    }

    /**
     * @param UserProfile|null $userProfile
     * @return array|null
     */
    public function formatUserProfileData(UserProfile $userProfile = null): ?array
    {
        if (empty($userProfile)) {
            return null;
        }
        $data['birthday'] = $userProfile->getBirthDay()->format('Y-m-d');
        $data['age'] = $userProfile->getBirthDay()->age;
        $data['height'] = $userProfile->getHeight();
        $data['body_type'] = $this->formatPropertyWithLabelAndValue('body_type', $userProfile->getBodyType());
        $data['marriage_intention'] = $this->formatPropertyWithLabelAndValue('marriage_intention', $userProfile->getMarriageIntention());
        $data['character'] = $this->formatPropertyWithLabelAndValue('character', $userProfile->getCharacter());
        $data['smoking'] = $this->formatPropertyWithLabelAndValue('smoking', $userProfile->getSmoking());
        $data['drinking'] = $this->formatPropertyWithLabelAndValue('drinking', $userProfile->getDrinking());
        $data['divorce'] = $this->formatPropertyWithLabelAndValue('divorce', $userProfile->getDivorce());
        $data['annual_income'] = $this->formatPropertyWithLabelAndValue('annual_income', $userProfile->getAnnualIncome());
        $data['appearance_strength'] = $userProfile->getAppearanceStrength() ? $this->formatPropertyWithLabelAndValue('appearance_strength',  $userProfile->getAppearanceStrength()) : null;
        $data['appearance_features'] = $userProfile->getAppearanceFeatures() ? $this->formatPropertyWithLabelAndValue('appearance_strength',  $userProfile->getAppearanceFeatures()) : null;
        $data['education'] = $this->formatPropertyWithLabelAndValue('education', $userProfile->getEducation());
        $data['school'] = $this->formatSchoolData($userProfile->getSchool());
        $data['school_id'] = $userProfile->getSchool() ? $userProfile->getSchool()->getId() : '';
        $data['company_name'] = $userProfile->getCompanyName();
        $data['hobby'] = $userProfile->getHobby() ? $this->formatPropertyWithLabelAndValue('hobby', $userProfile->getHobby()) : null;
        $data['job'] = $this->formatPropertyWithLabelAndValue('job', $userProfile->getJob());

        return $data;
    }

    /**
     * @param UserPreference|null $userPreference
     * @return array|null
     */
    public function formatUserPreferenceData(UserPreference $userPreference = null): ?array
    {
        if (empty($userPreference)) {
            return null;
        }
        $data['age_from'] = $userPreference->getAgeFrom();
        $data['age_to'] = $userPreference->getAgeTo();
        $data['height_to'] = $userPreference->getHeightTo();
        $data['height_from'] = $userPreference->getHeightFrom();
        $data['partner_body_min'] = $this->formatPropertyWithLabelAndValue('preferred_body_shape', $userPreference->getPartnerBodyMin());
        $data['partner_body_max'] = $this->formatPropertyWithLabelAndValue('preferred_body_shape', $userPreference->getPartnerBodyMax());
        $data['smoking'] = $this->formatPropertyWithLabelAndValue('smoking', $userPreference->getSmoking());
        $data['drinking'] = $this->formatPropertyWithLabelAndValue('drinking', $userPreference->getDrinking());
        $data['divorce'] = $this->formatPropertyWithLabelAndValue('divorce', $userPreference->getDivorce());
        $data['annual_income'] = $this->formatPropertyWithLabelAndValue('annual_income', $userPreference->getAnnualIncome());
        $data['education'] = $this->formatPropertyWithLabelAndValue('education', $userPreference->getEducation());
        $data['job'] = $userPreference->getJob() ? $this->formatPropertyWithLabelAndValue('job', $userPreference->getJob()) : null;
        $data['face_preferences'] = $userPreference->getFacePreferences() ? $this->formatPropertyWithLabelAndValue('appearance_strength', $userPreference->getFacePreferences()) : null;
        $data['appearance_priority'] = $this->formatPropertyWithLabelAndValue('preferred_importance_of_looks', $userPreference->getAppearancePriority());
        $data['first_priority'] = $userPreference->getFirstPriority() ? $this->formatPropertyWithLabelAndValue('important_preferences', $userPreference->getFirstPriority()) : null;
        $data['second_priority'] = $userPreference->getSecondPriority() ? $this->formatPropertyWithLabelAndValue('important_preferences', $userPreference->getSecondPriority()) : null;
        $data['third_priority'] = $userPreference->getThirdPriority() ? $this->formatPropertyWithLabelAndValue('important_preferences', $userPreference->getThirdPriority()) : null;
        $data['hobby'] = $this->formatPropertyWithLabelAndValue('hobby', $userPreference->getHobby());

        return $data;
    }

    /**
     * @param UserInvitation $userInvitation
     * @return array
     */
    public function formatUserInvitationData(UserInvitation $userInvitation): ?array
    {
        if (empty($userInvitation)) {
            return null;
        }
        return [
            'promotion_code' =>  $userInvitation->getPromotionCode()
        ];
    }

    /**
     * @param $prefectureModelCollection
     * @return array
     */
    public function formatPrefectureDataCollection($prefectureModelCollection): array
    {
        $prefectureData = [];
        foreach ($prefectureModelCollection as $prefecture) {
            if ($prefecture->getPrefectureTranslation()) {
                $data['id'] = $prefecture->getId();
                $data['country_id'] = $prefecture->getCountryId();
                $data['name'] = $prefecture->getPrefectureTranslation()->getName();
                $prefectureData[] = $data;
            }
        }
        return $prefectureData;
    }


    /**
     * @param $schoolModelCollection
     * @return array
     */
    public function formatSchoolDataCollection($schoolModelCollection): array
    {
        $schoolData = [];
        foreach ($schoolModelCollection as $school) {
            $schoolData[] = $this->formatSchoolData($school);
        }
        return $schoolData;
    }

    /**
     * @param $school
     * @return array|null
     */
    public function formatSchoolData($school): ?array
    {
        if (empty($school)) {
            return null;
        }
        $data['id'] = $school->getId();
        $data['school_name'] = $school->getSchoolName();
        $data['education_group'] = $school->getEducationGroup();
        return $data;
    }

    /**
     * @param Collection $registrationOptions
     * @return array
     */
    public function formatRegistrationOptionDataCollection(Collection $registrationOptions): array
    {
        $registrationData = [];
        foreach ($registrationOptions as $option) {
            $registrationData[] = $this->formatRegistrationOptionData($option);
        }
        return $registrationData;
    }

    /**
     * @param RegisterOption $registrationOptions
     * @return array
     */
    public function formatRegistrationOptionData(RegisterOption $registrationOptions): array
    {
        $data['value'] = (int)$registrationOptions->getOptionValue();
        $data['sort'] = (int)$registrationOptions->getSort();
        $data['type'] = $registrationOptions->getType();
        $data['status'] = (int)$registrationOptions->getStatus();
        $data['register_options_translations'][] = $this->formatRegistrationOptionTranslationData($registrationOptions->getRegisterOptionTranslation());
        return $data;
    }

    /**
     * @param RegisterOptionTranslation $registerOptionTranslation
     * @return array
     */
    public function formatRegistrationOptionTranslationData(RegisterOptionTranslation $registerOptionTranslation): array
    {
        $data['label_name'] = $registerOptionTranslation->getLabelName();
        $data['display_name'] = $registerOptionTranslation->getDisplayName();
        return $data;
    }

    /**
     * @param string $imageName
     * @param int $userId
     * @param bool $isPrimary
     * @return array
     */
    public function getFormattedUserImageData(string $imageName, int $userId, bool $isPrimary = false): UserImage
    {
        return new UserImage(
            $userId,
            $imageName,
            1,
            $isPrimary
        );
    }

    /**
     * Get user image data
     *
     * @param User $user
     * @param array $formData
     * @return array
     * @throws \Exception
     */
    protected function getUserImagesData(User $user, array $formData): array
    {
        $userImages = [];
        $index = 1;
        if (!empty($formData['images'])) {
            $arrayImage = explode(',', $formData['images']);
            if (count($arrayImage) == 0) {
                throw new \Exception(__('registration.images_is_required'));
            }
            foreach ($arrayImage as $imageData) {
                $path = parse_url($imageData, PHP_URL_PATH);
                $filename = basename($path);
                if (trim($filename) == '') continue;
                array_push($userImages, self::getFormattedUserImageData($filename, $user->getId(), $index == 1));
                $index++;
            }
            if (count($userImages) == 0) {
                throw new \Exception(__('registration.images_is_required'));
            }
            return $userImages;
        }
        throw new \Exception(__('registration.images_is_required'));
    }

    /**
     * @param string $propertyName
     * @param $propertyValue
     * @return array
     */
    public function formatPropertyWithLabelAndValue(string $propertyName, $propertyValue = null): array
    {
        $result = [];
        if (gettype($propertyValue) == 'array') {
            foreach ($propertyValue as &$value) {
                $labelName = $this->registerOptionRepository->getRegisterOptionDisplayName($value, $propertyName);
                $item = [
                    'displayName' => !empty($labelName) ? $labelName : null,
                    'value' => $value
                ];
                $result[] = $item;
            }
        }else {
            $labelName = $this->registerOptionRepository->getRegisterOptionDisplayName($propertyValue, $propertyName);
            $result = [
                'displayName' => !empty($labelName) ? $labelName : null,
                'value' => $propertyValue
            ];
        }
        return $result;
    }
}
