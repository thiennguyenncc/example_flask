<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Application\Admin\EventHandler\Events\UserManagement\UserDeactivatedByAdmin;
use Bachelor\Application\Admin\EventHandler\Events\UserManagement\UserApprovedByAdmin;
use Bachelor\Application\Admin\EventHandler\Events\UserManagement\UsersCancelledByAdmin;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Services\ParticipantForRematchDomainService;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchService;
use Bachelor\Domain\MasterDataManagement\Area\Interfaces\AreaRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Services\UserPlanService;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Enums\IsFake;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User as UserEntity;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService;
use App\Imports\BulkApprovalUserImport;
use Bachelor\Domain\UserManagement\User\Traits\RegistrationDataExtractorTrait;
use Bachelor\Domain\UserManagement\UserPreferredArea\Models\UserPreferredArea;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Interfaces\EloquentRegisterOptionInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserAuthInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class AdminUserService
{
    use RegistrationDataExtractorTrait;
    /**
     * @var UserPlanService
     */
    private UserPlanService $userPlanService;

    /**
     * @var UserDomainService
     */
    private UserDomainService $userService;

    private UserRepositoryInterface $userRepository;
    private DatingDomainService $datingDomainService;
    private ParticipantMainMatchService $participantMainMatchService;
    private ParticipantForRematchDomainService $participantForRematchService;
    private UserTrialService $userTrialService;
    private EloquentRegisterOptionInterface $registerOptionRepository;
    private UserPlanRepositoryInterface $userPlanRepository;
    private UserTrialRepositoryInterface $userTrialRepository;
    private SubscriptionRepositoryInterface $subscriptionRepository;
    private AreaRepositoryInterface $areaRepository;
    private EloquentUserAuthInterface $userAuthRepository;
    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data = [];

    /**
     * AdminUserService constructor.
     * @param UserDomainService $userService
     * @param UserRepositoryInterface $userRepository
     * @param UserPlanRepositoryInterface $userPlanRepository
     * @param UserTrialRepositoryInterface $userTrialRepository
     * @param SubscriptionRepositoryInterface $subscriptionRepository
     * @param UserPlanService $userPlanService
     * @param UserTrialService $userTrialService
     * @param ParticipantMainMatchService $participantMainMatchService
     * @param DatingDomainService $datingDomainService
     * @param ParticipantForRematchDomainService $participantForRematchService
     * @param EloquentRegisterOptionInterface $registerOptionRepository
     * @param AreaRepositoryInterface $areaRepository
     * @param EloquentUserAuthInterface $userAuthRepository
     */
    public function __construct(
        UserDomainService $userService,
        UserRepositoryInterface $userRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        UserPlanService $userPlanService,
        UserTrialService $userTrialService,
        ParticipantMainMatchService $participantMainMatchService,
        DatingDomainService $datingDomainService,
        ParticipantForRematchDomainService $participantForRematchService,
        EloquentRegisterOptionInterface $registerOptionRepository,
        AreaRepositoryInterface $areaRepository,
        EloquentUserAuthInterface $userAuthRepository
    ) {
        $this->userService = $userService;
        $this->userRepository = $userRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->userTrialRepository = $userTrialRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->registerOptionRepository = $registerOptionRepository;
        $this->userPlanService = $userPlanService;
        $this->userTrialService = $userTrialService;
        $this->participantMainMatchService = $participantMainMatchService;
        $this->datingDomainService = $datingDomainService;
        $this->participantForRematchService = $participantForRematchService;
        $this->areaRepository = $areaRepository;
        $this->userAuthRepository = $userAuthRepository;
    }

    /**
     * List users
     *
     * @param array $params
     * @return array
     */
    public function listUsers(?string $search = "", ?int $gender = null, ?int $status = null, ?int $isFake = null, int $perPage = 50): array
    {
        return $this->userRepository->retrieveUserList($search, $gender, $status, $isFake, $perPage);
    }

    /**
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function getProfileUser(int $userId): array
    {
        $user = $this->userRepository->getAllUserDataById($userId);
        if (!$user) throw new Exception(__('admin_messages.user_not_found'));

        $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
        $userTrial = $this->userTrialRepository->getLatestTrialByUser($user);
        $subscription = $this->subscriptionRepository->getLatestSubscription($user);
        $userPreferredAreas = $user->getUserPreferredAreasCollection();

        $this->data['name'] = $user->getName();
        $this->data['mobile_number'] = $user->getMobileNumber();
        $this->data['status'] = $user->getStatus();
        $this->data['email'] = $user->getEmail();
        $this->data['gender'] = $user->getGender();
        $this->data['prefecture_id'] = $user->getPrefectureId();
        $this->data['team_member_rate'] = $user->getTeamMemberRate();

        $userAuthDAO = $this->userAuthRepository->getByUserId($user->getId());
        $this->data['user_auth'] = [
            'auth_id' => $userAuthDAO->auth_id,
            'auth_type' => $userAuthDAO->auth_type,
        ];

        $this->data['user_profile'] = $this->formatUserProfileData($user->getUserProfile());
        $this->data['user_profile']['education_group'] =
            $user->getUserProfile() ?
            $this->formatPropertyWithLabelAndValue(
                'education_group',
                $user->getUserProfile()->getSchool()?->getEducationGroup()
            ) :
            null;

        $this->data['user_preference'] = $this->formatUserPreferenceData($user->getUserPreference());
        $this->data['user_images'] = $user->getUserImagesCollection() ? $this->formatUserImageCollectionData($user->getUserImagesCollection()) : [];
        if (!empty($user->getUserPreferredAreasCollection())) {
            foreach ($userPreferredAreas as $userPreferredArea) {
                /* @var UserPreferredArea $userPreferredArea */
                $userPreferredAreaId = $userPreferredArea->getAreaId();
                $priority = $userPreferredArea->getPriority();
                $this->data['user_preferred_areas'][$priority]['name'] = $this->areaRepository->getSpecificArea($userPreferredAreaId)->getAreaTranslation()->getName();
            }
        }

        $this->data['user_plan']['name'] = $userPlan?->getPlan()?->getName();
        $this->data['user_plan']['price'] = $userPlan?->getPlan()?->getFinalAmount();
        $this->data['user_plan']['nickname'] = $userPlan?->getPlan()?->getNickname();
        $this->data['user_plan']['contract_term'] = $userPlan?->getPlan()?->getContractTerm();

        $this->data['user_trial']['status'] = $userTrial?->getStatus();
        $this->data['user_trial']['trial_ended_at'] = $userTrial?->getTrialEnd();

        $this->data['subscription']['current_subscription_starts_at'] = $subscription?->getStartsAt();
        $this->data['subscription']['current_subscription_ends_at'] = $subscription?->getEndsAt();

        return $this->data;
    }

    /**
     * Approve users
     *
     * @param int[] $userIds
     * @return array
     */
    public function approveUsers(array $userIds): array
    {
        $users = $this->userRepository->getByIds($userIds, null, null, ['userInfoUpdatedTime']);

        $result = [];
        foreach ($users as $user) {
            try {
                $this->approveOneUserByAdmin($user);
                $result['success'][] = $user->getId();
            } catch (\Throwable $th) {
                $result['failed'][] = $user->getId();
                Log::error($th, [
                    'user_id' => $user->getId()
                ]);
            }
        }

        return $result;
    }


    /**
     * Approve one user by admin
     *
     * @param UserEntity $user
     * @return array
     * @throws \Exception
     */
    private function approveOneUserByAdmin(UserEntity $user): bool
    {
        //Validate user trial, subscription and participant
        $this->userService->validateUserBeforeApprove($user);

        $user->approve();
        $this->userRepository->save($user);

        if ($user->getGender() === UserGender::Male) {
            $this->userPlanService->createFirstUserPlan($user);
            $this->userTrialService->startTrialIfValid($user);
        }

        UserApprovedByAdmin::dispatch($user);

        return true;
    }

    /**
     * Deactivate users
     *
     * @param $userIds
     * @return array
     */
    public function deactivateUsers(array $userIds): array
    {
        $users = $this->userRepository->getByIds($userIds);
        $result = [];
        $users->each(function (UserEntity $user) {
            try {
                $result = $this->userService->validateUserCanCancelDeactivateAccount($user, false);
                if ($result['need_cancel_participant']) {
                    $this->participantMainMatchService->cancelAllAwaitingForUser($user);
                }
                if ($result['need_cancel_participant_for_rematch']) {
                    $this->participantForRematchService->cancelAllAwaitingForUser($user);
                }
                if ($result['need_cancel_incompleted_dating']) {
                    $this->datingDomainService->cancelAllIncompletedDatingForUser($user);
                }
                $user = $this->userService->deactivateUserAccount($user);

                UserDeactivatedByAdmin::dispatch($user);

                $result['success'][] = $user->getId();
            } catch (Throwable $e) {
                $result['failed'][] = $user->getId();
            }
        });

        return $result;
    }

    /**
     * Cancel users
     *
     * @param $userIds
     * @return array
     */
    public function cancelUsers(array $userIds): array
    {
        $users = $this->userRepository->getByIds($userIds);
        $result = [];
        $users->each(function (UserEntity $user) {
            try {
                $validation = $this->userService->validateUserCanCancelDeactivateAccount($user, false);
                if ($validation['need_cancel_participant']) {
                    $this->participantMainMatchService->cancelAllAwaitingForUser($user);
                }
                if ($validation['need_cancel_participant_for_rematch']) {
                    $this->participantForRematchService->cancelAllAwaitingForUser($user);
                }
                if ($validation['need_cancel_incompleted_dating']) {
                    $this->datingDomainService->cancelAllIncompletedDatingForUser($user);
                }
                $user = $this->userService->cancelUserAccount($user);

                UsersCancelledByAdmin::dispatch($user);
                $result['success'][] = $user->getId();
            } catch (Throwable $e) {
                $result['failed'][] = $user->getId();
            }
        });

        return $result;
    }

    /**
     * Get the user preferred data
     *
     * @param array $params
     * @return array
     */
    public function getUserPreferredAreaData(array $params): array
    {
        return $this->userService->getUserPreferredAreaData($params);
    }

    /**
     * Set fake user
     *
     * @param int $userId
     * @param bool $fake
     * @return bool
     * @throws \Exception
     */
    public function setFakeUser($userId, $fake = true): bool
    {
        /* @var User $user */
        $user = $this->userRepository->getById($userId);

        if (!$user) throw new \Exception(__('admin_messages.user_not_found'));

        if ($user->getStatus() != UserStatus::ApprovedUser || $user->getGender() != UserGender::Female)
            throw new Exception('fake user should be approved female user');

        $user->setIsFake($fake ? IsFake::FakeUser : IsFake::RealUser);
        return (bool) $this->userRepository->save($user);
    }

    /**
     * @param $filePath
     * @return array
     */
    public function bulkApprovalFromFile($filePath): array
    {
        $bulkApprovalUserImport = new BulkApprovalUserImport;

        Excel::import($bulkApprovalUserImport, $filePath);

        return ['failures' => $bulkApprovalUserImport->getFailures()];
    }
}
