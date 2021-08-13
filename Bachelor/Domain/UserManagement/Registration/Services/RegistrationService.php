<?php

namespace Bachelor\Domain\UserManagement\Registration\Services;

use Bachelor\Domain\MasterDataManagement\Area\Interfaces\AreaRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Prefecture\Interfaces\PrefectureRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\School\Interfaces\SchoolRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\Registration\Events\GottenStepZeroData;
use Bachelor\Domain\UserManagement\Registration\Events\StoredUserDataFromRegistrationForm;
use Bachelor\Domain\UserManagement\User\Enums\EducationType;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService;
use Bachelor\Domain\UserManagement\User\Traits\RegistrationDataExtractorTrait;
use Bachelor\Domain\UserManagement\UserInvitation\Interfaces\UserInvitationInterface;
use Bachelor\Domain\UserManagement\UserInvitation\Models\UserInvitation;
use Bachelor\Domain\UserManagement\UserPreference\Interfaces\UserPreferenceInterface;
use Bachelor\Domain\UserManagement\UserPreferredArea\Interfaces\UserPreferredAreasInterface;
use Bachelor\Domain\UserManagement\UserPreferredArea\Models\UserPreferredArea;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserImageInterface;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;
use Bachelor\Domain\UserManagement\UserPreference\Models\UserPreference;
use Bachelor\Domain\UserManagement\UserProfile\Models\UserProfile;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Repository\EloquentRegisterOptionRepository;
use Bachelor\Utility\Enums\Status;
use Carbon\Carbon;

class RegistrationService
{
    use RegistrationDataExtractorTrait;

    private UserRepositoryInterface $userRepository;

    private UserProfileInterface $userProfileRepository;

    private UserPreferenceInterface $userPreferenceRepository;

    private UserPreferredAreasInterface $userPreferredAreasRepository;

    private UserInvitationInterface $userInvitationRepository;

    private UserImageInterface $userImageRepository;

    private SchoolRepositoryInterface $schoolRepository;

    private UserPlanRepositoryInterface $userPlanRepository;

    private PrefectureRepositoryInterface $prefectureRepository;

    private AreaRepositoryInterface $areaRepository;

    private EloquentRegisterOptionRepository $registerOptionRepository;

    private UserDomainService $userService;

    /**
     * RegistrationService constructor.
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        SchoolRepositoryInterface $schoolRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        PrefectureRepositoryInterface $prefectureRepository,
        EloquentRegisterOptionRepository $registerOptionRepository,
        AreaRepositoryInterface $areaRepository,
        UserProfileInterface $userProfileRepository,
        UserPreferenceInterface $userPreferenceRepository,
        UserInvitationInterface $userInvitationRepository,
        UserImageInterface $userImageRepository,
        UserPreferredAreasInterface $userPreferredAreasRepository,
        UserDomainService $userService
    ) {
        $this->userRepository = $userRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->schoolRepository = $schoolRepository;
        $this->prefectureRepository = $prefectureRepository;
        $this->registerOptionRepository = $registerOptionRepository;
        $this->areaRepository = $areaRepository;
        $this->userProfileRepository = $userProfileRepository;
        $this->userPreferenceRepository = $userPreferenceRepository;
        $this->userInvitationRepository = $userInvitationRepository;
        $this->userImageRepository = $userImageRepository;
        $this->userPreferredAreasRepository = $userPreferredAreasRepository;
        $this->userService = $userService;
    }

    /**
     * Retrieve data for registration
     *
     * @param User $user
     * @param int $step
     * @return mixed
     */
    public function getUserDataForRegistration(User $user, int $step): array
    {
        switch ($step) {
            case RegistrationSteps::StepZero:
                return $this->getUserDataStepZero($user);
            case RegistrationSteps::StepOne:
                return $this->getUserDataStepOne($user);
            case RegistrationSteps::StepTwo:
                return $this->getUserDataStepTwo($user);
            case RegistrationSteps::StepThree:
                return $this->getUserDataStepThree($user);
            case RegistrationSteps::StepFour:
                return $this->getUserDataStepFour($user);
            case RegistrationSteps::StepFive:
                return $this->getUserDataStepFive($user);
            case RegistrationSteps::StepSix:
                return $this->getUserDataStepSix($user);
            case RegistrationSteps::StepSeven:
                return $this->getUserDataStepSeven($user);
            case RegistrationSteps::StepEight:
                return $this->getUserDataStepEight($user);
            case RegistrationSteps::StepNine:
                return $this->getUserDataStepNine($user);
            case RegistrationSteps::StepTen:
                return $this->getUserDataStepTen($user);
            case RegistrationSteps::StepEleven:
                return $this->getUserDataStepEleven($user);
            case RegistrationSteps::StepTwelve:
                return $this->getUserDataStepTwelve($user);
            case RegistrationSteps::StepThirteenth:
                return $this->getUserDataStepThirteenth($user);
            case RegistrationSteps::StepFourteenth:
                return $this->getUserDataStepFourteenth($user);
            case RegistrationSteps::StepFifteenth:
                return $this->getUserDataStepFifteenth($user);
            default:
                return [];
        }
    }

    /**
     * Store data from registration form
     *
     * @param User $user
     * @param $step
     * @param $formData
     * @return bool
     * @throws \Exception
     */
    public function storeUserDataFromRegistrationForm(User $user, int $step, $formData): bool
    {
        switch ($step) {
            case RegistrationSteps::StepZero:
                $result = $this->storeUserRegistrationDataStepZero($user, $formData);
                break;
            case RegistrationSteps::StepOne:
                $result = $this->storeUserRegistrationDataStepOne($user, $formData);
                break;
            case RegistrationSteps::StepTwo:
                $result = $this->storeUserRegistrationDataStepTwo($user, $formData);
                break;
            case RegistrationSteps::StepThree:
                $result = $this->storeUserRegistrationDataStepThree($user, $formData);
                break;
            case RegistrationSteps::StepFour:
                $result = $this->storeUserRegistrationDataStepFour($user, $formData);
                break;
            case RegistrationSteps::StepFive:
                $result = $this->storeUserRegistrationDataStepFive($user, $formData);
                break;
            case RegistrationSteps::StepSix:
                $result = $this->storeUserRegistrationDataStepSix($user, $formData);
                break;
            case RegistrationSteps::StepSeven:
                $result = $this->storeUserRegistrationDataStepSeven($user, $formData);
                break;
            case RegistrationSteps::StepEight:
                $result = $this->storeUserRegistrationDataStepEight($user, $formData);
                break;
            case RegistrationSteps::StepNine:
                $result = $this->storeUserRegistrationDataStepNine($user, $formData);
                break;
            case RegistrationSteps::StepTen:
                $result = $this->storeUserRegistrationDataStepTen($user, $formData);
                break;
            case RegistrationSteps::StepEleven:
                $result = $this->storeUserRegistrationDataStepEleven($user, $formData);
                break;
            case RegistrationSteps::StepTwelve:
                $result = $this->storeUserRegistrationDataStepTwelve($user, $formData);
                break;
            case RegistrationSteps::StepThirteenth:
                $result = $this->storeUserRegistrationDataStepThirteenth($user, $formData);
                break;
            case RegistrationSteps::StepFourteenth:
                $result = $this->storeUserRegistrationDataStepFourteenth($user, $formData);
                break;
            case RegistrationSteps::StepFifteenth:
                $result = $this->storeUserRegistrationDataStepFifteenth($user, $formData);
                break;
            default:
                $result = false;
        }

        return $result;
    }

    /**
     * Get all user data
     *
     * @param User $user
     * @param int $step
     * @return mixed
     */
    public function getUserDataStepZero(User $user): array
    {
        GottenStepZeroData::dispatch($user);
        $data['prefectureData'] = $this->formatPrefectureDataCollection($this->prefectureRepository->getPrefectureCollectionByStatus(Status::Active));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * obtain properties step two
     *
     * @return mixed
     */
    public function getUserDataStepOne(User $user): array
    {
        // obtain properties step two
        $data['appearanceStrength'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.appearance_strength')));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepTwo(User $user): array
    {
        // obtain properties step two
        $data['preferredMaxAge'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_max_age'), $user->getGender()));
        $data['preferredMinAge'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_min_age'), $user->getGender()));
        $data['preferredMaxHeight'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_max_height'), $user->getGender()));
        $data['preferredMinHeight'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_min_height'), $user->getGender()));
        $data['preferredJob'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_job'), $user->getGender()));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepThree(User $user): array
    {
        $data['preferredBodyShape'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_body_shape'), $user->getGender()));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepFour(User $user): array
    {
        $data['preferredDivorced'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_divorced')));
        $data['preferredDrink'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_drink')));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepFive(User $user): array
    {
        $data['preferredAnnualIncome'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_annual_income')));
        $data['preferredSmoke'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_smoke')));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepSix(User $user): array
    {
        $data['job'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.job'), $user->getGender()));
        $data['annualIncome'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.annual_income')));
        $data['education'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.education')));
        $data['preferredDivorced'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_divorced')));
        $data['preferredDrink'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_drink')));
        $data['educationGroup'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.education_group')));
        $data['schoolData'] = $this->formatSchoolDataCollection($this->schoolRepository->getAllSchools());
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepSeven(User $user): array
    {
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => []
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepEight(User $user): array
    {
        $data['profileHeight'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.profile_height'), $user->getGender()));
        $data['profileBodyType'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.profile_body_type'), $user->getGender()));
        $data['education'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.education')));
        $data['educationGroup'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.education_group')));
        $data['schoolData'] = $this->formatSchoolDataCollection($this->schoolRepository->getAllSchools());
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepNine(User $user): array
    {
        $data['strengthsOfAppearance'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.strengths_of_appearance'), $user->getGender()));
        $data['appearanceFeatures'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.appearance_features')));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepTen(User $user): array
    {
        $data['characters'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.character'), $user->getGender()));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepEleven(User $user): array
    {
        $data['hobbies'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.hobby'), $user->getGender()));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepTwelve(User $user): array
    {
        $data['drinking'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.drinking'), $user->getGender()));
        $data['smoking'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.smoking'), $user->getGender()));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepThirteenth(User $user): array
    {
        $data['divorce'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.divorce')));
        $data['marriageIntention'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.marriage_intention')));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepFourteenth(User $user): array
    {
        $data['preferredImportanceOfLooks'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.preferred_importance_of_looks')));
        $data['ImportantPreferences'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(config('registration_option_type.important_preferences')));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Get all user data
     *
     * @return mixed
     */
    public function getUserDataStepFifteenth(User $user): array
    {
        $data['areasData'] = $this->formatAreasData($this->areaRepository->getAreasByPrefectureId($user->getPrefectureId()));
        return [
            'user' => $this->obtainTransformedUserData($user),
            'formData' => $data
        ];
    }

    /**
     * Transform user data before retrieving
     *
     * @param User $user
     * @param int $step
     * @param bool $generateImageUrl
     * @return array
     */
    public function obtainTransformedUserData(User $user): array
    {
        $user = $this->userRepository->getAllUserDataById($user->getId());
        $userInvitation = $this->userInvitationRepository->retrieveUserInvitationByUserId($user->getId());
        $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());

        $data['name'] = $user->getName();
        $data['mobile_number'] = $user->getMobileNumber();
        $data['status'] = $user->getStatus();
        $data['email'] = $user->getEmail();
        $data['gender'] = $user->getGender();
        $data['is_complete_2nd_form'] = $user->getRegistrationCompleted();
        $data['registration_steps'] = $user->getRegistrationSteps();
        $data['prefecture_id'] = $user->getPrefectureId();
        $data['dating_plan'] = $userPlan ? $userPlan->getPlan() ? $userPlan->getPlan()->getName() : '' : '';
        $data['user_profile'] = $this->formatUserProfileData($user->getUserProfile());
        $data['user_preference'] = $this->formatUserPreferenceData($user->getUserPreference());
        $data['user_invitation'] = $userInvitation ? $this->formatUserInvitationData($userInvitation) : [];
        $data['user_images'] = $user->getUserImagesCollection() ? $this->formatUserImageCollectionData($user->getUserImagesCollection()) : [];
        $data['user_preferred_areas'] = $user->getUserPreferredAreasCollection() ? $this->formatUserPreferredAreasCollectionData($user->getUserPreferredAreasCollection()) : [];
        $data['prefecture'] = $this->formatPrefectureData($user->getPrefecture());

        return $data;
    }

    /**
     * Store user related data step zero
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepZero(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setPrefectureId($formData['prefectureId']);
        $this->userService->setEmailIfValid($userDomainModel, $formData['email']);
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepZero);
        $userDomainModel->setGender($formData['gender']);

        // save user invitation
        $userInvitation = $this->userInvitationRepository->retrieveUserInvitationByUserId($user->getId());
        if (empty($userInvitation)) {
            $userInvitation = new UserInvitation($user->getId(), '', '', $formData['code']);
            $userInvitation->setUserId($user->getId());
            $userInvitation->setPromotionCode($formData['code']);
        } else if (!$userDomainModel->getRegistrationCompleted() && isset($formData['code'])) {
            $userInvitation->setPromotionCode($formData['code']);
        }

        // save user profile information
        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        if (empty($userProfile)) {
            $userProfile = new UserProfile($user->getId());
            $userProfile->setUserId($user->getId());
        }
        $userProfile->setBirthDay(Carbon::parse($formData['year'] . '-' . $formData['month'] . '-' . $formData['date']));
        return $this->userRepository->save($userDomainModel) && $this->userProfileRepository->save($userProfile) && $this->userInvitationRepository->save($userInvitation);
    }

    /**
     * Store user related data step one
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepOne(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepOne);

        $userPreference = $this->userPreferenceRepository->retrieveUserPreferenceByUserId($user->getId());
        if (empty($userPreference)) {
            $userPreference = new UserPreference($user->getId());
            $userPreference->setUserId($user->getId());
        }
        $userPreference->setFacePreferences(explode(',', $formData['facePreferences']));

        return $this->userRepository->save($userDomainModel) && $this->userPreferenceRepository->save($userPreference);
    }

    /**
     * Store user related data step two
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepTwo(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepTwo);

        $userPreference = $this->userPreferenceRepository->retrieveUserPreferenceByUserId($user->getId());
        if (empty($userPreference)) {
            $userPreference = new UserPreference($user->getId());
            $userPreference->setUserId($user->getId());
        }
        $userPreference->setAgeFrom($formData['minAge']);
        $userPreference->setAgeTo($formData['maxAge']);
        $userPreference->setHeightFrom($formData['minHeight']);
        $userPreference->setHeightTo($formData['maxHeight']);
        $userPreference->setJob(explode(',', $formData['job']));

        return $this->userRepository->save($userDomainModel) && $this->userPreferenceRepository->save($userPreference);
    }

    /**
     * Store user related data step one
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepThree(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepThree);

        $userPreference = $this->userPreferenceRepository->retrieveUserPreferenceByUserId($user->getId());
        if (empty($userPreference)) {
            $userPreference = new UserPreference($user->getId());
            $userPreference->setUserId($user->getId());
        }
        $userPreference->setPartnerBodyMin($formData['bodyType1']);
        $userPreference->setPartnerBodyMax($formData['bodyType2']);
        $userPreference->setEducation($formData['education']);

        return $this->userRepository->save($userDomainModel) && $this->userPreferenceRepository->save($userPreference);
    }

    /**
     * Store user related data step one
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepFour(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepFour);

        $userPreference = $this->userPreferenceRepository->retrieveUserPreferenceByUserId($user->getId());
        if (empty($userPreference)) {
            $userPreference = new UserPreference($user->getId());
            $userPreference->setUserId($user->getId());
        }
        $userPreference->setDrinking($formData['alcohol']);
        $userPreference->setDivorce($formData['divorce']);

        return $this->userRepository->save($userDomainModel) && $this->userPreferenceRepository->save($userPreference);
    }

    /**
     * Store user related data step one
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepFive(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepFive);

        $userPreference = $this->userPreferenceRepository->retrieveUserPreferenceByUserId($user->getId());
        if (empty($userPreference)) {
            $userPreference = new UserPreference($user->getId());
            $userPreference->setUserId($user->getId());
        }
        $userPreference->setAnnualIncome($formData['annualIncome'] ?? null);
        $userPreference->setSmoking($formData['smoking'] ?? null);

        return $this->userRepository->save($userDomainModel) && $this->userPreferenceRepository->save($userPreference);
    }

    /**
     * Store user related data step one
     *
     * @param User $user
     * @param array $formData
     * @return bool
     * @throws \Exception
     */
    public function storeUserRegistrationDataStepSix(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepSix);
        $userDomainModel->setName($formData['userName'] ?? '');

        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        if (empty($userProfile)) {
            $userProfile = new UserProfile($user->getId());
            $userProfile->setUserId($user->getId());
        }
        $userProfile->setJob($formData['job'] ?? null);
        $userProfile->setAnnualIncome($formData['annualIncome'] ?? null);
        $userProfile->setEducation($formData['education'] ?? null);
        if (isset($formData['schoolId']) && $formData['schoolId']) {
            $school = $this->schoolRepository->getSchoolById($formData['schoolId']);
            if (!$school) {
                throw new \Exception(__('registration.school_name_is_required'));
            }
            $userProfile->setSchool($school);
        } else {
            if (in_array($userProfile->getEducation(), [EducationType::Other, EducationType::HighSchoolGraduation])) {
                $userProfile->setSchool(null);
            }
        }

        return $this->userRepository->save($userDomainModel) && $this->userProfileRepository->save($userProfile);
    }

    /**
     * Store user related data step one
     *
     * @param User $user
     * @param array $formData
     * @return bool
     * @throws \Exception
     */
    public function storeUserRegistrationDataStepSeven(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepSeven);
        $userImages = $this->getUserImagesData($user, $formData);
        foreach ($userImages as $userImage) {
            $this->userImageRepository->save($userImage);
        }
        return (bool)$this->userRepository->save($userDomainModel);
    }

    /**
     * Store user related data step Seven
     *
     * @param User $user
     * @param array $formData
     * @return bool
     * @throws \Exception
     */
    public function storeUserRegistrationDataStepEight(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepEight);

        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        if (empty($userProfile)) {
            $userProfile = new UserProfile($user->getId());
            $userProfile->setUserId($user->getId());
        }
        $userProfile->setHeight($formData['height']);
        $userProfile->setBodyType($formData['bodyType']);
        $userProfile->setEducation($formData['education']);
        if (isset($formData['school'])) {
            $school = $this->schoolRepository->getSchoolById($formData['school']);
            if (!$school) {
                throw new \Exception(__('registration.school_name_is_required'));
            }
            $userProfile->setSchool($school);
        }

        return $this->userRepository->save($userDomainModel) && $this->userProfileRepository->save($userProfile);
    }

    /**
     * Store user related data step Eight
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepNine(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepNine);
        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        if (empty($userProfile)) {
            $userProfile = new UserProfile($user->getId());
            $userProfile->setUserId($user->getId());
        }
        $userProfile->setAppearanceStrength($formData['appearanceStrength']);
        return $this->userRepository->save($userDomainModel) && $this->userProfileRepository->save($userProfile);
    }

    /**
     * Store user related data step Nine
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepTen(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepTen);

        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        if (empty($userProfile)) {
            $userProfile = new UserProfile($user->getId());
            $userProfile->setUserId($user->getId());
        }
        $userProfile->setCharacter(explode(',', $formData['character']));

        return $this->userRepository->save($userDomainModel) && $this->userProfileRepository->save($userProfile);
    }

    /**
     * Store user related data step Ten
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepEleven(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepEleven);

        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        if (empty($userProfile)) {
            $userProfile = new UserProfile($user->getId());
            $userProfile->setUserId($user->getId());
        }
        $userProfile->setHobby(explode(',', $formData['hobby']));

        return $this->userRepository->save($userDomainModel) && $this->userProfileRepository->save($userProfile);
    }

    /**
     * Store user related data step Eleven
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepTwelve(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepTwelve);

        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        if (empty($userProfile)) {
            $userProfile = new UserProfile($user->getId());
            $userProfile->setUserId($user->getId());
        }
        $userProfile->setDrinking($formData['alcohol']);
        if (isset($formData['smoking'])) {
            $userProfile->setSmoking($formData['smoking']);
        }
        if (isset($formData['divorce'])) {
            $userProfile->setDivorce($formData['divorce']);
        }
        if (isset($formData['marriage'])) {
            $userProfile->setMarriageIntention($formData['marriage']);
        }

        return $this->userRepository->save($userDomainModel) && $this->userProfileRepository->save($userProfile);
    }

    /**
     * Store user related data step Twelve
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepThirteenth(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepThirteenth);

        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        if (empty($userProfile)) {
            $userProfile = new UserProfile($user->getId());
            $userProfile->setUserId($user->getId());
        }
        $userProfile->setDivorce($formData['divorce']);
        $userProfile->setMarriageIntention($formData['willingnessForMarriage']);

        return $this->userRepository->save($userDomainModel) && $this->userProfileRepository->save($userProfile);
    }

    /**
     * Store user related data step Thirteenth
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepFourteenth(User $user, array $formData): bool
    {
        // save user information
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepFourteenth);

        $userPreference = $this->userPreferenceRepository->retrieveUserPreferenceByUserId($user->getId());
        if (empty($userPreference)) {
            $userPreference = new UserPreference($user->getId());
            $userPreference->setUserId($user->getId());
        }
        $importantPreferences = $formData['importantPreferences'];
        $userPreference->setAppearancePriority($formData['importanceOfLookValue']);
        $userPreference->setFirstPriority(count($importantPreferences) > 0 ? $importantPreferences[0] : null);
        $userPreference->setSecondPriority(count($importantPreferences) > 1 ? $importantPreferences[1] : null);
        $userPreference->setThirdPriority(count($importantPreferences) > 2 ? $importantPreferences[2] : null);

        return $this->userRepository->save($userDomainModel) && $this->userPreferenceRepository->save($userPreference);
    }

    /**
     * Store user related data step Thirteenth
     *
     * @param User $user
     * @param array $formData
     * @return bool
     */
    public function storeUserRegistrationDataStepFifteenth(User $user, array $formData): bool
    {
        $userDomainModel = $this->userRepository->getById($user->getId());
        $userDomainModel->setRegistrationSteps(RegistrationSteps::StepFifteenth);

        //save user prefer place
        $usePreferredAreaIds =  $formData['userPreferredAreas'];
        for ($i = 0; $i < count($usePreferredAreaIds); $i++) {
            $preferredAreaId  = $usePreferredAreaIds[$i];
            $currentPreferredArea = $this->userPreferredAreasRepository->getByUserIdAndAreaId($user->getId(), $preferredAreaId);
            if (!$currentPreferredArea) {
                $currentPreferredArea = new UserPreferredArea($userDomainModel->getId(), $preferredAreaId, $i);
            } else {
                $currentPreferredArea->setPriority($i);
            }
            $this->userPreferredAreasRepository->save($currentPreferredArea);
        }

        return (bool)$this->userRepository->save($userDomainModel);
    }
}
