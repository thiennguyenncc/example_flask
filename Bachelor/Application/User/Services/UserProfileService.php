<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\MasterDataManagement\Area\Interfaces\AreaRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Prefecture\Interfaces\PrefectureRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\RegisterOption\Enums\RegistrationOptionType;
use Bachelor\Domain\MasterDataManagement\School\Enums\ValidationMessages;
use Bachelor\Domain\MasterDataManagement\School\Interfaces\SchoolRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\Registration\Services\RegistrationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User as UserDomainEntity;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService;
use Bachelor\Domain\UserManagement\User\Traits\RegistrationDataExtractorTrait;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;
use Bachelor\Domain\UserManagement\UserProfile\Services\UserProfileDomainService;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Repository\EloquentRegisterOptionRepository;
use Exception;
use Illuminate\Http\Response;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Carbon\Carbon;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserProperty;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Interfaces\EloquentRegisterOptionInterface;
use Illuminate\Support\Facades\DB;

class UserProfileService
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

    private UserDomainService $userDomainService;

    private UserRepositoryInterface $userRepository;

    private UserTrialService $userTrialService;

    private UserPlanRepositoryInterface $userPlanRepository;

    private UserCouponRepositoryInterface $userCouponRepository;

    private SubscriptionRepositoryInterface $subscriptionRepository;
    /**
     * @var UserProfileInterface
     */
    private UserProfileInterface $userProfileRepository;

    private UserProfileDomainService $userProfileService;

    private EloquentRegisterOptionInterface $registerOptionRepository;

    private SchoolRepositoryInterface $schoolRepository;

    private AreaRepositoryInterface $areaRepository;

    private PrefectureRepositoryInterface $prefectureRepository;


    public function __construct(
        UserDomainService $userDomainService,
        UserRepositoryInterface $userRepository,
        RegistrationService $registration,
        UserPlanRepositoryInterface $userPlanRepository,
        UserCouponRepositoryInterface $userCouponRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        UserProfileInterface $userProfileRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        EloquentRegisterOptionInterface $registerOptionRepository,
        UserProfileDomainService $userProfileService,
        SchoolRepositoryInterface $schoolRepository,
        AreaRepositoryInterface $areaRepository,
        PrefectureRepositoryInterface $prefectureRepository,
        UserTrialService $userTrialService
    ) {
        $this->userDomainService = $userDomainService;
        $this->userRepository = $userRepository;
        $this->registration = $registration;
        $this->userPlanRepository = $userPlanRepository;
        $this->userCouponRepository = $userCouponRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userProfileRepository = $userProfileRepository;
        $this->userTrialRepository = $userTrialRepository;
        $this->registerOptionRepository = $registerOptionRepository;
        $this->userProfileService = $userProfileService;
        $this->schoolRepository = $schoolRepository;
        $this->areaRepository = $areaRepository;
        $this->prefectureRepository = $prefectureRepository;
        $this->userTrialService = $userTrialService;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get Profile Info
     *
     * @param UserDomainEntity $user
     * @return self
     */
    public function getProfileInfo(UserDomainEntity $user): self
    {
        $user = $this->userRepository->getById($user->getId(), [
            UserProperty::UserProfile,
            UserProperty::Prefecture
        ]);

        $formData = [];
        $optionTypes = [
            RegistrationOptionType::Job,
            RegistrationOptionType::AnnualIncome,
            RegistrationOptionType::Education,
            RegistrationOptionType::EducationGroup,
            RegistrationOptionType::ProfileHeight,
            RegistrationOptionType::MarriageIntention,
            RegistrationOptionType::Smoking,
            RegistrationOptionType::Drinking,
            RegistrationOptionType::Divorce,
        ];
        foreach ($optionTypes as $optionType) {
            $options = $this->registerOptionRepository->getRegistrationOptionByType($optionType, $user->getGender());
            $formattedOptions = $this->formatRegistrationOptionDataCollection($options);
            $formData[$optionType] = $formattedOptions;
        }
        $formData['school_data'] = $this->formatSchoolDataCollection($this->schoolRepository->getAllSchools());
        $data = $this->formatUserProfileData($user->getUserProfile());
        $data['dating_areas'] = $this->formatPrefectureData($user->getPrefecture());
        $data['user_email'] = $user->getEmail();

        $this->data = [
            'formData' => $formData,
            'data' => $data
        ];

        return $this;
    }

    /**
     * Update User Profile Information
     *
     * @param UserDomainEntity $user
     * @param array $params [
     * birthday: string|null,
     * height: int|null,
     * bodyType: int|null,
     * marriageIntention: int|null,
     * character[]: array|null,
     * smoking:int|null,
     * drinking:int|null,
     * divorce:string|null,
     * annualIncome:int|null,
     * appearanceStrength[]:array|null,
     * appearanceFeatures[]:array|null,
     * education:string|null,
     * companyName:string|null,
     * job:int|null,
     * hobby[]:array|null,
     * schoolId:int|null
     * ]
     * @return self
     * @throws Exception
     */
    public function updateProfile(UserDomainEntity $user, ?array $params): self
    {
        DB::beginTransaction();
        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());
        $userProfile->setBirthDay($params['birthday'] != null ? Carbon::make($params['birthday']) : null);
        if (isset($params['height'])) $userProfile->setHeight($params['height']);
        if (isset($params['bodyType'])) $userProfile->setBodyType($params['bodyType']);
        if (isset($params['marriageIntention'])) $userProfile->setMarriageIntention($params['marriageIntention']);
        if (isset($params['character'])) $userProfile->setCharacter($params['character']);
        if (isset($params['smoking'])) $userProfile->setSmoking($params['smoking']);
        if (isset($params['drinking'])) $userProfile->setDrinking($params['drinking']);
        if (isset($params['divorce'])) $userProfile->setDivorce($params['divorce']);
        if (isset($params['annualIncome'])) $userProfile->setAnnualIncome($params['annualIncome']);
        if (isset($params['appearanceStrength'])) $userProfile->setAppearanceStrength($params['appearanceStrength']);
        if (isset($params['appearance_features'])) $userProfile->setAppearanceFeatures($params['appearance_features']);
        if (isset($params['companyName'])) $userProfile->setCompanyName($params['companyName']);
        if (isset($params['job'])) $userProfile->setJob($params['job']);
        if (isset($params['hobby'])) $userProfile->setHobby($params['hobby']);
        if (isset($params['education'])) $userProfile->setEducation($params['education']);
        if ($params['schoolId'] != null) {
            $school = $this->schoolRepository->getSchoolById($params['schoolId']);
            if (!$school) throw BaseValidationException::withMessages(ValidationMessages::schoolDoesNotExist);
            $userProfile->setSchool($school);
        }
        if ($this->userProfileRepository->save($userProfile)) {
            DB::commit();
            $this->message = __('api_messages.userProfile.successfully_updated_profile');
            return $this;
        }
        DB::rollBack();
        throw new Exception(__('api_messages.userProfile.unable_to_update_profile'));
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
