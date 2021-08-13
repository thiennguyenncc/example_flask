<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Domain\AuthenticationManagement\Authentication\Enums\UserAuthType;
use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\Base\TimeSetting\Services\TimeSettingService;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\RegisterOption\Enums\RegistrationOptionType;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\UserManagement\Registration\Services\RegistrationService;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\ValidationMessages;
use Bachelor\Domain\UserManagement\User\Events\GetReactivatedFemaleOrPaidMale;
use Bachelor\Domain\UserManagement\User\Events\GetReactivatedTrialMaleUser;
use Bachelor\Domain\UserManagement\User\Events\GetReapprovedFemaleOrPaidMale;
use Bachelor\Domain\UserManagement\User\Events\GetReapprovedTrialMaleUser;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User as UserDomainEntity;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService;
use Bachelor\Domain\UserManagement\User\Traits\RegistrationDataExtractorTrait;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Utility\Helpers\Utility;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Enums\UserProperty;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Interfaces\EloquentRegisterOptionInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserService
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

    /**
     * Response data
     *
     * @var array
     */
    protected $data = [];

    private UserTrialRepositoryInterface $userTrialRepository;

    private InvoiceRepositoryInterface $invoiceRepository;

    private UserDomainService $userDomainService;

    private SubscriptionRepositoryInterface $subscriptionRepository;

    private UserPlanRepositoryInterface $userPlanRepository;

    private UserTrialService $userTrialService;

    private UserCouponRepositoryInterface $userCouponRepository;

    private EloquentRegisterOptionInterface $registerOptionRepository;

    private UserProfileInterface $userProfileRepository;

    private DatingRepositoryInterface $datingRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserDomainService $userDomainService,
        TimeSettingService $timeSetting,
        UserRepositoryInterface $userRepository,
        RegistrationService $registration,
        SubscriptionRepositoryInterface $subscriptionRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        UserTrialService $userTrialService,
        UserCouponRepositoryInterface $userCouponRepository,
        EloquentRegisterOptionInterface $registerOptionRepository,
        UserProfileInterface $userProfileRepository,
        DatingRepositoryInterface $datingRepository
    ) {
        $this->userDomainService = $userDomainService;
        $this->timeSetting = $timeSetting;
        $this->userRepository = $userRepository;
        $this->registration = $registration;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userTrialRepository = $userTrialRepository;
        $this->userTrialService = $userTrialService;
        $this->userPlanRepository = $userPlanRepository;
        $this->userCouponRepository = $userCouponRepository;
        $this->registerOptionRepository = $registerOptionRepository;
        $this->userProfileRepository = $userProfileRepository;
        $this->datingRepository = $datingRepository;
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    public function getGlobalInfo(UserDomainEntity $user)
    {
        $subscription = $this->subscriptionRepository->getAppliedSubscription($user);
        $userTrial = $this->userTrialRepository->getLatestTrialByUser($user);

        return [
            'user_status' => $user->getStatus(),
            'user_gender' => $user->getGender(),
            'email' => $user->getEmail(),
            'mobile_number' => $user->getMobileNumber(),
            'has_applied_subscription' => !!$subscription,
            'trial_status' => $userTrial?->getStatus(),
            'current_server_time' => Carbon::now(),
            'registration_steps' => $user->getRegistrationSteps(),
            'registration_complete' => $user->getRegistrationCompleted(),
        ];
    }

    /**
     * Update User email
     *
     * @param UserDomainEntity $user
     * @param string $email
     * @return array
     * @throws Exception|Throwable
     */
    public function updateEmail(UserDomainEntity $user, string $email): array
    {
        $this->userDomainService->setEmailIfValid($user, $email);

        if (!$this->userRepository->save($user)) {
            throw BaseValidationException::withMessages([
                'email_update_failed' => [__('api_messages.user.email_update_failed')]
            ]);
        }

        $this->message = __('api_messages.user.successfully_updated_email');

        return $this->handleApiResponse();
    }

    /**
     * Migrate user account
     *
     * @param Authenticatable $authAccountToMigrateTo
     * @param string $mobileNumber
     * @return string
     * @throws Exception
     */
    public function handleUserAccountMigration(Authenticatable $authAccountToMigrateTo, string $mobileNumber): string
    {
        return $this->userDomainService->migrateUserAccount(
            $this->userDomainService->retrieveUserAuthByAuthId(Utility::decode($mobileNumber))->first(),
            $this->userDomainService->retrieveUserAuthByAuthId($authAccountToMigrateTo->auth_id)->first(),
            UserAuthType::Mobile
        );
    }

    /**
     * Retrieve user
     *
     * @param $value
     * @param string $via
     * @return User
     */
    public function retrieveUser($value, string $via = 'id'): User
    {
        $method = 'retrieveUserBy' . ucfirst($via);

        return $this->userDomainService->$method($value)->first();
    }

    /**
     * @param UserDomainEntity $user
     * @param array $params
     * @return UserService
     * @throws Exception
     */
    public function reactivateOrReapproveUser(UserDomainEntity $user, array $params): self
    {
        $userStatus = $user->getStatus();
        switch ($user->getGender()) {
            case UserGender::Male:
                $subscription = $this->subscriptionRepository->getLatestSubscription($user);
                if ($subscription) {
                    $result = $this->userDomainService->reactivateOrReApproveForPaidMaleUser($user, $params);
                    if ($result && $userStatus == UserStatus::CancelledUser) {
                        GetReapprovedFemaleOrPaidMale::dispatch($user);
                    } elseif ($result && $userStatus == UserStatus::DeactivatedUser) {
                        GetReactivatedFemaleOrPaidMale::dispatch($user);
                    }
                } else {
                    $result = $this->userDomainService->reactivatedOrReApproveForTrialMaleUser($user);
                    if ($result && $userStatus == UserStatus::CancelledUser) {
                        GetReapprovedTrialMaleUser::dispatch($user);
                    } elseif ($result && $userStatus == UserStatus::DeactivatedUser) {
                        GetReactivatedTrialMaleUser::dispatch($user);
                    }
                }
                break;
            case UserGender::Female:
                $this->userDomainService->reactivateOrReapproveFemaleUser($user);
                break;
        }
        return $this;
    }

    public function getMypageInfo(UserDomainEntity $user): self
    {
        $user = $this->userRepository->getById($user->getId(), [
            UserProperty::UserProfile
        ]);
        $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
        $subscription = $this->subscriptionRepository->getAppliedSubscription($user);
        $userTrial = $this->userTrialRepository->getLatestTrialByUser($user);
        $scheduledUserPlan = $this->userPlanRepository->getScheduledUserPlanByUserId($user->getId());
        $trialStatusOrPaid = $user->getTrialStatusOrPaid($subscription, $userTrial);
        $bachelorRate = $user->getBRate();
        $couponNumber = $this->userCouponRepository->getAllAvailableCoupon($user)->count();
        $hasCompletedDating = $this->datingRepository->hasCompletedDating($user);

        $data["age"] = $user->getUserProfile()->getAge();
        $data["job"] = $this->registerOptionRepository->getRegisterOptionDisplayName($user->getUserProfile()->getJob(), RegistrationOptionType::Job);

        $data['user_status'] = $user->getStatus();
        $data['user_name'] = $user->getName();
        $data['user_gender'] = $user->getGender();
        $data['bachelor_rate'] = $bachelorRate;
        $data['trial_status_or_paid'] = $trialStatusOrPaid;
        $data['dating_plan'] = $userPlan?->getPlan()?->getCostPlanKey() ?: '';
        $data['new_plan'] = $scheduledUserPlan?->getPlan()?->getCostPlanKey() ?: '';
        $data['new_plan_id'] = $scheduledUserPlan?->getPlan()?->getId() ?: '';
        $data['subscription_start'] = $subscription?->getJaStartsAt() ?: '';
        $data['subscription_end'] = $subscription?->getJaEndsAt() ?: '';
        $data['next_subscription_start'] = $subscription?->getJaNextStartsAt() ?: '';
        $data['trial_start'] = $userTrial?->getStatus() === TrialStatus::Active ? $userTrial->getJaTrialStart() : '';
        $data['trial_end'] = $userTrial?->getStatus() === TrialStatus::Active ? $userTrial->getJaTrialEnd() : '';
        $data['coupon_number'] = $couponNumber;
        $data['cost_plan_name'] = $userPlan?->getPlan()?->getCostPlan()?->getName() ?: '';
        $data['cost_plan_monthly_fee'] = $userPlan?->getPlan()?->getFinalAmount() ?: '';
        $data['cost_plan_per_dating_fee'] = $userPlan?->getPlan()?->getAmountPerDating() ?: '';
        $data['has_completed_dating'] = $hasCompletedDating;

        $this->data = $data;

        return $this;
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
