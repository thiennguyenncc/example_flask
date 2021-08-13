<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Domain\MasterDataManagement\RegisterOption\Enums\RegistrationOptionType;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\UserManagement\Registration\Services\RegistrationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserProperty;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User as UserDomainEntity;
use Bachelor\Domain\UserManagement\User\Traits\RegistrationDataExtractorTrait;
use Bachelor\Domain\UserManagement\UserPreference\Services\UserPreferenceDomainService;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Repository\EloquentRegisterOptionRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreference\Repository\UserPreferenceRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserPreferenceService
{
    use RegistrationDataExtractorTrait, RegistrationDataExtractorTrait;

    /**
     * Response Status
     */
    protected $status;

    /**
     * Response Message
     */
    protected $message;

    private UserTrialRepositoryInterface $userTrialRepository;

    private InvoiceRepositoryInterface $invoiceRepository;

    /**
     * Response data
     *
     * @var array
     */
    protected $data = [];

    private RegistrationService $registration;

    private UserPreferenceRepository $userPreferenceRepository;

    private UserPreferenceDomainService $userPreferenceService;

    private EloquentRegisterOptionRepository $registerOptionRepository;

    private UserPlanRepositoryInterface $userPlanRepository;

    private UserRepositoryInterface $userRepository;

    private UserProfileInterface $userProfileRepository;

    public function __construct(
        RegistrationService $registration,
        UserPreferenceRepository $userPreferenceRepository,
        UserPreferenceDomainService $userPreferenceService,
        EloquentRegisterOptionRepository $registerOptionRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        UserRepositoryInterface $userRepository,
        UserProfileInterface $userProfileRepository,
    ) {
        $this->registration = $registration;
        $this->userPreferenceRepository = $userPreferenceRepository;
        $this->userPreferenceService = $userPreferenceService;
        $this->registerOptionRepository = $registerOptionRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get Preference Info
     *
     * @param UserDomainEntity $user
     * @return self
     */
    public function getPreferenceInfo(UserDomainEntity $user): self
    {
        $userId = $user->getId();
        $userGender = $user->getGender();

        $formData = [];
        $optionTypeWithOutGender = [
            RegistrationOptionType::PreferredAnnualIncome,
            RegistrationOptionType::Smoking,
            RegistrationOptionType::PreferredDivorced,
            RegistrationOptionType::PreferredDrink,
            RegistrationOptionType::PreferredBodyShape,
            RegistrationOptionType::PreferredImportanceOfLooks,
            RegistrationOptionType::ImportantPreferences,
            RegistrationOptionType::EducationGroup,
            RegistrationOptionType::Education,
        ];
        $optionCollectionWithOutGender = $this->registerOptionRepository->getRegistrationOptionByTypes($optionTypeWithOutGender);
        $optionDateCollections = $this->formatRegistrationOptionDataCollection($optionCollectionWithOutGender);

        foreach ($optionDateCollections as $optionDateCollection) {
            if ($optionDateCollection['type'] == RegistrationOptionType::PreferredAnnualIncome && $userGender === UserGender::Female) {
                $formData['preferred_annual_income'][] = $optionDateCollection;
            }
            if ($optionDateCollection['type'] == RegistrationOptionType::Smoking && $userGender === UserGender::Female) {
                $formData['smoking'][] = $optionDateCollection;
            }
            if ($optionDateCollection['type'] == RegistrationOptionType::PreferredDivorced) {
                $formData['preferred_divorced'][] = $optionDateCollection;
            }
            if ($optionDateCollection['type'] == RegistrationOptionType::PreferredDrink) {
                $formData['preferred_drink'][] = $optionDateCollection;
            }
            if ($optionDateCollection['type'] == RegistrationOptionType::PreferredBodyShape) {
                $formData['preferred_body_shape'][] = $optionDateCollection;
            }
            if ($optionDateCollection['type'] == RegistrationOptionType::PreferredImportanceOfLooks) {
                $formData['preferred_importance_of_looks'][] = $optionDateCollection;
            }
            if ($optionDateCollection['type'] == RegistrationOptionType::ImportantPreferences) {
                $formData['important_preferences'][] = $optionDateCollection;
            }
            if ($optionDateCollection['type'] == RegistrationOptionType::EducationGroup) {
                $formData['education_group'][] = $optionDateCollection;
            }
            if ($optionDateCollection['type'] == RegistrationOptionType::Education) {
                $formData['education'][] = $optionDateCollection;
            }
        }
        $formData['preferred_max_age'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(RegistrationOptionType::PreferredMaxAge, $userGender));
        $formData['preferred_min_age'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(RegistrationOptionType::PreferredMinAge, $userGender));
        $formData['preferred_max_height'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(RegistrationOptionType::PreferredMaxHeight, $userGender));
        $formData['preferred_min_height'] = $this->formatRegistrationOptionDataCollection($this->registerOptionRepository->getRegistrationOptionByType(RegistrationOptionType::PreferredMinHeight, $userGender));

        $userPreference = $this->userPreferenceRepository->retrieveUserPreferenceByUserId($user->getId());
        $data = $this->formatUserPreferenceData($userPreference);

        $activePlan = $this->userPlanRepository->getActiveUserPlanByUserId($userId);
        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        $data['cost_plan'] = $activePlan ? $activePlan->getPlan()->getCostPlanKey() : "";
        $data['user_age'] = $userProfile->getAge();

        $this->data = [
            'formData' => $formData,
            'data' => $data
        ];

        return $this;
    }

    /**
     * Update User Preference Information
     *
     * @param UserDomainEntity $user
     * @param array $params [
     * ageFrom: int|null,
     * ageTo: int|null,
     * heightFrom: int|null,
     * heightTo: int|null,
     * partnerBodyMin: int|null,
     * partnerBodyMax: int|null,
     * smoking: int|null,
     * drinking: int|null,
     * divorce: string|null,
     * annualIncome: int|null,
     * education: string|null,
     * job[]: array|null,
     * facePreferences[]: array|null,
     * appearancePriority: string|null,
     * firstPriority: int|null,
     * secondPriority: int|null,
     * thirdPriority:int|null,
     * hobby: string|null
     * ]
     * @return self
     * @throws Exception
     */
    public function updatePreference(UserDomainEntity $user, array $params): self
    {
        DB::beginTransaction();
        $user = $this->userRepository->getById($user->getId(), [
            UserProperty::UserProfile,
            UserProperty::UserPreference
        ]);
        $userPreference = $user->getUserPreference();

        if (isset($params['ageFrom'])) $userPreference->setAgeFrom($params['ageFrom']);
        if (isset($params['ageTo'])) if ($this->userPreferenceService->validationAgeTo($user, $params['ageTo'])) $userPreference->setAgeTo($params['ageTo']);
        if (isset($params['heightFrom'])) $userPreference->setHeightFrom($params['heightFrom']);
        if (isset($params['heightTo'])) $userPreference->setHeightTo($params['heightTo']);
        if (isset($params['partnerBodyMin'])) $userPreference->setPartnerBodyMin($params['partnerBodyMin']);
        if (isset($params['partnerBodyMax'])) $userPreference->setPartnerBodyMax($params['partnerBodyMax']);
        if (isset($params['smoking'])) $userPreference->setSmoking($params['smoking']);
        if (isset($params['drinking'])) $userPreference->setDrinking($params['drinking']);
        if (isset($params['divorce'])) $userPreference->setDivorce($params['divorce']);
        if (isset($params['annualIncome'])) $userPreference->setAnnualIncome($params['annualIncome']);
        if (isset($params['education'])) $userPreference->setEducation($params['education']);
        if (isset($params['job'])) $userPreference->setJob($params['job']);
        if (isset($params['facePreferences'])) $userPreference->setFacePreferences($params['facePreferences']);
        if (isset($params['appearancePriority'])) $userPreference->setAppearancePriority($params['appearancePriority']);
        if (isset($params['firstPriority'])) $userPreference->setFirstPriority($params['firstPriority']);
        if (isset($params['secondPriority'])) $userPreference->setSecondPriority($params['secondPriority']);
        if (isset($params['thirdPriority'])) $userPreference->setThirdPriority($params['thirdPriority']);
        if (isset($params['hobby'])) $userPreference->setHobby($params['hobby']);
        if ($this->userPreferenceRepository->save($userPreference)) {
            $this->message = __('api_messages.userPreference.successfully_updated_preference');
            DB::commit();
            return $this;
        }
        DB::rollBack();
        throw new Exception(__('api_messages.userPreference.unable_to_update_preference'));
    }

    /**
     * Format Registration data
     *
     * @return array
     */
    public function handleApiResponse(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
