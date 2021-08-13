<?php

namespace Bachelor\Domain\UserManagement\User\Services;

use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\PaymentCard\Interfaces\PaymentCardInterface;
use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\PaymentManagement\Plan\Enum\ContractTerm;
use Bachelor\Domain\PaymentManagement\Plan\Enum\DiscountType;
use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Interfaces\ParticipantForRematchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\ExtSubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Enums\ValidationMessages;
use Bachelor\Domain\UserManagement\User\Events\CancelledAccount;
use Bachelor\Domain\UserManagement\User\Events\DeactivatedAccount;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User as UserEntity;
use Bachelor\Domain\UserManagement\User\Models\UserMigration;
use Bachelor\Domain\UserManagement\User\Rules\ExistsEmail;
use Bachelor\Domain\UserManagement\User\Rules\SendableEmail;
use Bachelor\Domain\UserManagement\User\Traits\RegistrationDataExtractorTrait;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentCancelDeactivateFormInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserAccountMigrationLogInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserActionLogInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserAuthInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class UserDomainService
{
    use RegistrationDataExtractorTrait;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EloquentUserAuthInterface
     */
    private $userAuthRepository;

    /**
     * @var EloquentUserAccountMigrationLogInterface
     */
    private $userAccountMigrationLogRepository;

    /*
     * @var EloquentUserActionLogInterface
     */
    private $userActionLogRepository;

    /**
     * @var EloquentCancelDeactivateFormInterface
     */
    protected EloquentCancelDeactivateFormInterface $cancelDeactivateFormRepository;
    protected DatingRepositoryInterface $datingRepository;
    protected ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;
    protected ParticipantForRematchRepositoryInterface $participantForRematchRepository;
    protected ExtSubscriptionRepositoryInterface $extSubscriptionRepository;
    protected SubscriptionRepositoryInterface $subscriptionRepository;

    private UserProfileInterface $userProfileRepository;

    private PaymentCardInterface $paymentCardRepository;

    private UserTrialRepositoryInterface  $userTrialRepository;

    private UserPlanRepositoryInterface  $userPlanRepository;

    private InvoiceRepositoryInterface $invoiceRepository;

    private UserCouponRepositoryInterface $userCouponRepository;

    private PlanRepositoryInterface $planRepository;


    /*
     * UserDomainService Constructor
     *
     * @param UserAuthRepositoryInterface $userAuthRepository
     */

    public function __construct(
        UserRepositoryInterface $userRepository,
        EloquentUserAuthInterface $userAuthRepository,
        EloquentUserAccountMigrationLogInterface $userAccountMigrationLogRepository,
        EloquentUserActionLogInterface $userActionLogRepository,
        EloquentCancelDeactivateFormInterface $cancelDeactivateFormRepository,
        PaymentCardInterface $paymentCardRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        ParticipantForRematchRepositoryInterface $participantForRematchRepository,
        ExtSubscriptionRepositoryInterface $extSubscriptionRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        DatingRepositoryInterface $datingRepository,
        InvoiceRepositoryInterface $invoiceRepository,
        UserCouponRepositoryInterface $userCouponRepository,
        PlanRepositoryInterface $planRepository
    ) {
        $this->userRepository = $userRepository;
        $this->userAuthRepository = $userAuthRepository;
        $this->userAccountMigrationLogRepository = $userAccountMigrationLogRepository;
        $this->userActionLogRepository = $userActionLogRepository;
        $this->cancelDeactivateFormRepository = $cancelDeactivateFormRepository;
        $this->paymentCardRepository = $paymentCardRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->userTrialRepository = $userTrialRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->datingRepository = $datingRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->participantForRematchRepository = $participantForRematchRepository;
        $this->extSubscriptionRepository = $extSubscriptionRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->userCouponRepository = $userCouponRepository;
        $this->planRepository = $planRepository;
    }

    /**
     * Get the user preferred data
     *
     * @param array $params
     * @return array
     */
    public function getUserPreferredAreaData(array $params): array
    {
        $user = $this->userRepository->getUserPreferredAreaData($params);
        $result = [];
        if ($user && $user->getUserPreferredAreasCollection()) {
            $result = $this->formatUserPreferredAreasCollectionData($user->getUserPreferredAreasCollection());
        }
        return $result;
    }

    /**
     * Retrieve user auth query builder
     *
     * @param string $authId
     * @return mixed
     */
    public function retrieveUserAuthByAuthId(string $authId): Builder
    {
        // Retrieve the user auth query builder ( helpful in case we cant to add additional conditions to it )
        return $this->userAuthRepository->retrieveUserAuthViaAuthIdQueryBuilder($authId);
    }

    /**
     * Create new user
     *
     * @param string $authId
     * @param array $userAuthData
     * @return mixed
     */
    public function createAndRetrieveNewUserAuth(string $authId, array $userAuthData): UserAuth
    {
        // Create new user auth data and retrieve it
        $userAuth = $this->userAuthRepository->createNewUserAuth($userAuthData);
        $userAuth->user = $userAuth->user()->first();
        return $userAuth;
    }

    /**
     * Update user data and retrieve user
     *
     * @param Builder $userAuthQueryBuilder
     * @param array $userAuthData
     * @return UserAuth
     */
    public function updateAndRetrieveUserData(Builder $userAuthQueryBuilder, array $userAuthData): UserAuth
    {
        $userAuth = $userAuthQueryBuilder->first();
        $userAuth->update($userAuthData);
        $userAuth->user()->update($userAuthData['user']);
        $userAuth->refresh();
        return $userAuth;
    }

    /**
     *  Get user data after authentication
     *
     * @param UserAuth $userAuth
     * @return array
     */
    public function retrieveUserDataAfterAuthentication(UserAuth $userAuth): array
    {
        // Get user data
        $user = $userAuth->user->toDomainEntity();
        $subscription = $this->subscriptionRepository->getAppliedSubscription($user);
        $userTrial = $this->userTrialRepository->getLatestTrialByUser($user);
        $userInfo = [
            'status' => $user->getStatus(),
            'has_success_date' => $this->datingRepository->hasCompletedDating($user),
            'has_applied_subscription' => !!$subscription,
            'trial_status' => $userTrial?->getStatus(),
        ];
        return array_merge(
            $this->userAuthRepository->getUserDataAfterAuthentication($userAuth),
            $userInfo
        );
    }

    /**
     * Migrate user account
     *
     * @param UserAuth $authAccountToMigrateTo
     * @param UserAuth $authAccountToMigrateFrom
     * @param string $authType
     * @return string
     * @throws BindingResolutionException
     * @throws Exception
     */
    public function migrateUserAccount(UserAuth $authAccountToMigrateTo, UserAuth $authAccountToMigrateFrom, string $authType): string
    {
        DB::beginTransaction();

        // Instantiate new User migration class
        return (new UserMigration($authAccountToMigrateTo, $authAccountToMigrateFrom, $authType))
            ->handleUserAccountMigrationLog() // Make a log of the migration before migrating data
            ->analyzeUserAccountForMigration(); // Migrate user account data
    }

    /**
     * Update user status to deactivate
     *
     * @param UserEntity $user
     * @return UserEntity
     * @throws Exception
     */
    public function deactivateUserAccount(UserEntity $user): UserEntity
    {
        $this->validateUserCanCancelDeactivateAccount($user);
        $user = $this->userRepository->save($user->deactivateAccount());
        DeactivatedAccount::dispatch($user);

        return $user;
    }

    /**
     * Update user status to cancel
     *
     * @param UserEntity $user
     * @return UserEntity
     * @throws Exception
     */
    public function cancelUserAccount(UserEntity $user): UserEntity
    {
        $this->validateUserCanCancelDeactivateAccount($user);
        $user = $this->userRepository->save($user->cancelAccount());
        CancelledAccount::dispatch($user);

        return $user;
    }

    /**
     * validate if user can cancel, deactivate or not
     *
     * @param UserEntity $user
     * @param boolean $exception
     * @return array
     *      $result = [
     *          'need_cancel_participant' => false,
     *          'need_cancel_participant_for_rematch' => false,
     *          'need_cancel_incompleted_dating' => false,
     *          'need_fill_feedback' => false,
     *          'need_pay_for_invoice' => false,
     *      ];
     * @throws Exception if $exception is false, this doesn't throw exception
     */
    public function validateUserCanCancelDeactivateAccount(UserEntity $user, bool $exception = true): array
    {
        $result = [
            'need_cancel_participant' => false,
            'need_cancel_participant_for_rematch' => false,
            'need_cancel_incompleted_dating' => false,
            'need_fill_feedback' => false,
            'need_pay_for_invoice' => false,
        ];

        if ($this->participantMainMatchRepository->getAwaitingForUser($user)->count()) {
            if ($exception) {
                throw BaseValidationException::withMessages([
                    'cant_cancel_account' => [__("api_messages.cancel_deactivate_account.you_have_to_cancel_participation")]
                ]);
            }
            $result['need_cancel_participant'] = true;
        };
        if ($this->participantForRematchRepository->getAwaitingForUser($user)->count()) {
            if ($exception) {
                throw BaseValidationException::withMessages([
                    'cant_cancel_account' => [__("api_messages.cancel_deactivate_account.you_have_to_cancel_participation_for_rematch")]
                ]);
            }
            $result['need_cancel_participant_for_rematch'] = true;
        };
        if ($this->datingRepository->getDatingsByUserId($user->getId(), DatingStatus::Incompleted)->count()) {
            if ($exception) {
                throw BaseValidationException::withMessages([
                    'cant_cancel_account' => [__("api_messages.cancel_deactivate_account.you_have_to_cancel_dating")]
                ]);
            }
            $result['need_cancel_incompleted_dating'] = true;
        };
        if ($this->datingRepository->getDatingsNoFeedbackByUserId($user->getId(), DatingStatus::Completed)->count()) {
            if ($exception) {
                throw BaseValidationException::withMessages([
                    'cant_cancel_account' => [__("api_messages.cancel_deactivate_account.you_have_to_give_feedback")]
                ]);
            }
            $result['need_fill_feedback'] = true;
        };

        return $result;
    }

    /**
     * @param UserEntity $user
     * @param array $data
     * @param int $type
     */
    public function createCancelDeactivateForm(UserEntity $user, array $data, int $type)
    {
        $param['type'] = $type;
        $param['user_id'] = $user->getId();
        $param['reason_about_date'] = $data['reason_about_date'] ?? null;
        $param['reason_about_date_other_text'] = $data['reason_about_date_other_text'] ?? null;
        $param['reason_about_date_i_not_prefer_other_text'] = $data['reason_about_date_i_not_prefer_other_text'] ?? null;
        $param['reason_about_service'] = $data['reason_about_service'] ?? null;
        $param['reason_about_service_other_text'] = $data['reason_about_service_other_text'] ?? null;
        $param['improvements_feedback'] = $data['improvements_feedback'] ?? null;
        $param['other_opinion_feedback'] = $data['other_opinion_feedback'] ?? null;

        $this->cancelDeactivateFormRepository->create($param);
    }

    /**
     * Re-activated or Re-approved for trial user
     *
     * @param UserEntity $user
     * @return bool
     * @throws Exception
     */
    public function reactivatedOrReApproveForTrialMaleUser(UserEntity $user): bool
    {
        // Validate trial user before reactivated
        $this->validateTrialUserBeforeReactivateOrReapprove($user);

        return (bool)$this->userRepository->save($user->approve());
    }

    /**
     * Re-activated Or Re-approved Female user
     *
     * @param UserEntity $user
     * @return boolean
     * @throws Exception
     */

    public function reactivateOrReapproveFemaleUser(UserEntity $user): bool
    {
        $this->validateFemaleBeforeReactivateOrReapprove($user);

        return (bool)$this->userRepository->save($user->approve());
    }

    /**
     * Re-activated or Re-approved for Female or Paid Male
     *
     * @param UserEntity $user
     * @param array $params
     * @return bool
     * @throws Exception
     */
    public function reactivateOrReApproveForPaidMaleUser(UserEntity $user, array $params): bool
    {
        // Validate user before reactivated
        $this->validatePaidMaleUserBeforeReactivateOrReapprove($user, $params);

        //get plan_id with new cost plan & subscription month
        $systemPlan = $this->planRepository->getPlanCollection(
            DiscountType::NoDiscount,
            $params['costPlan'],
            $params['contractTerm']
        );
        //update new user new plan
        $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
        $userPlan->setPlan($systemPlan->first());
        $this->userPlanRepository->save($userPlan);

        $subscription = $this->subscriptionRepository->getLatestSubscription($user);
        if ($subscription) {
            // if ok then start subscription for this user
            $plan = $userPlan->getPlan();
            if ($this->extSubscriptionRepository->createSubscription(
                $user->getUserPaymentCustomer(),
                $plan,
            )) {
                $this->userRepository->save($user->approve());
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Validate Female before Re-activated or Re-approved
     * @throws BaseValidationException
     */
    private function validateFemaleBeforeReactivateOrReapprove(UserEntity $user)
    {
        if ($user->getStatus() !== UserStatus::DeactivatedUser && $user->getStatus() !== UserStatus::CancelledUser) {
            throw BaseValidationException::withMessages(ValidationMessages::InvalidStatus);
        }
        //check unpaid invoice
        if ($this->invoiceRepository->getAllUnpaidInvoicesWhichGracePeriodExpiredByUser($user)->count() > 0) {
            throw BaseValidationException::withMessages(ValidationMessages::UserHasUnpaidInvoice);
        }
    }

    /**
     * Validate trial user before Re-activated or Re-approved
     * @param UserEntity $user
     * @throws Exception
     */
    private function validateTrialUserBeforeReactivateOrReapprove(UserEntity $user)
    {
        if ($user->getStatus() !== UserStatus::DeactivatedUser && $user->getStatus() !== UserStatus::CancelledUser) {
            throw BaseValidationException::withMessages(ValidationMessages::InvalidStatus);
        }

        if (!$this->userTrialRepository->getLatestTrialByUser($user) && $user->getGender() == UserGender::Male) {
            throw BaseValidationException::withMessages(ValidationMessages::UserDontHaveTrial);
        }
    }

    /**
     * Validate Paid Male user before Re-activated or Re-approved
     * @param UserEntity $user
     * @param array $params
     * @throws BaseValidationException
     */
    private function validatePaidMaleUserBeforeReactivateOrReapprove(UserEntity $user, array $params)
    {
        if(!CostPlan::hasValue($params['costPlan']) || !ContractTerm::hasValue($params['contractTerm'])){
            throw BaseValidationException::withMessages(ValidationMessages::InvalidCostPlan);
        }

        //valid plan in db
        $systemPlan = $this->planRepository->getPlanCollection(
            DiscountType::NoDiscount,
            $params['costPlan'],
            $params['contractTerm']
        );
        if(!$systemPlan->first()){
            throw BaseValidationException::withMessages(ValidationMessages::InvalidCostPlan);
        }

        if ($user->getStatus() !== UserStatus::DeactivatedUser && $user->getStatus() !== UserStatus::CancelledUser) {
            throw BaseValidationException::withMessages(ValidationMessages::InvalidStatus);
        }
        //check unpaid invoice
        if ($this->invoiceRepository->getAllUnpaidInvoicesWhichGracePeriodExpiredByUser($user)->count() > 0) {
            throw BaseValidationException::withMessages([
                'has_unpaid_invoice' => [
                    'ご利用できません',
                ],
                'hosted_invoice_url' => [$this->invoiceRepository->getAllUnpaidInvoicesWhichGracePeriodExpiredByUser($user)->first()->getHostedInvoiceUrl()]
            ]);
        }

        if (!$this->datingRepository->hasCompletedDating($user)) {
            throw BaseValidationException::withMessages(ValidationMessages::UserPaidDontHaveSuccessDate);
        }

        if ($this->paymentCardRepository->getPaymentCardCollectionByUser($user)->count() == 0) {
            throw BaseValidationException::withMessages(ValidationMessages::UserDontHaveCard);
        }
    }

    /**
     * Validate user condition before approve
     * @param UserEntity $user
     * @throws \Exception
     */
    public function validateUserBeforeApprove(UserEntity $user)
    {
        if ($this->userTrialRepository->getLatestTrialByUser($user)?->isTrialActive()) {
            throw BaseValidationException::withMessages(ValidationMessages::UserHasTrialActive);
        }

        if ($this->subscriptionRepository->getLatestSubscription($user)) {
            throw BaseValidationException::withMessages(ValidationMessages::UserHaveSubscription);
        }
    }

    /**
     * @param UserEntity $user
     * @param $email
     * @throws Exception
     */
    public function setEmailIfValid(UserEntity $user, $email)
    {
        $validator = Validator::make(['email' => $email], ['email' => [new SendableEmail, new ExistsEmail]]);
        if ($validator->fails()) {
            throw new BaseValidationException($validator);
        }
        $user->setEmail($email);
    }

    /**
     * @param UserEntity $user
     * @return UserEntity
     * @throws BaseValidationException
     */
    public function setUserStatusToIncomplete(UserEntity $user): UserEntity
    {
        if ($user->getGender() == UserGender::Male) {
            return $this->saveUserIncomplete($user);
        }

        // if user = female, continue check user has awaiting participated or not
        $weekStartDate = Carbon::now()->startOfWeek()->toDateString();
        $participatedHistory = $this->participantMainMatchRepository->getParticipatedHistoryForUser($user, $weekStartDate);
        $isEmptyParticipated = $participatedHistory->contains(function ($item) {
            return $item->getStatus() == ParticipantsStatus::Awaiting;
        });
        if (!$isEmptyParticipated) {
            return $this->saveUserIncomplete($user);
        }

        return $user;
    }

    /**
     * @throws BaseValidationException
     */
    private function saveUserIncomplete(UserEntity $user): UserEntity
    {
        return $this->userRepository->save($user->cancelAwaiting());
    }
}
