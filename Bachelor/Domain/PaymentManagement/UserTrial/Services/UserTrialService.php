<?php

namespace Bachelor\Domain\PaymentManagement\UserTrial\Services;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\ExtSubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Factories\UserTrialFactory;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Models\UserTrial;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\UserManagement\User\Events\CompletedTrial;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Exception;
use Carbon\Carbon;



class UserTrialService
{
    /**
     * @var UserTrialRepositoryInterface
     */
    private UserTrialRepositoryInterface $userTrialRepository;

    /**
     * @var UserTrialFactory
     */
    private UserTrialFactory $userTrialFactory;

    protected  UserRepositoryInterface $userRepository;

    protected  UserPlanRepositoryInterface $userPlanRepository;

    protected  ExtSubscriptionRepositoryInterface $extSubscriptionRepository;

    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    /**
     * UserTrialService constructor.
     * @param UserTrialRepositoryInterface $userTrialRepository
     * @param UserTrialFactory $userTrialFactory
     */
    public function __construct(
        UserTrialRepositoryInterface $userTrialRepository,
        UserTrialFactory $userTrialFactory,
        UserRepositoryInterface $userRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        ExtSubscriptionRepositoryInterface $extSubscriptionRepositoryInterface,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
    ) {
        $this->userTrialRepository = $userTrialRepository;
        $this->userTrialFactory = $userTrialFactory;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->userRepository = $userRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->extSubscriptionRepository = $extSubscriptionRepositoryInterface;
    }

    /**
     *  Start user trial
     *
     * @param User $user
     * @return UserTrial|null
     * @throws Exception
     */
    public function startTrialIfValid(User $user): ?UserTrial
    {
        // Skip if not eligible user
        $currentUserTrial = $this->userTrialRepository->getLatestTrialByUser($user);
        if ($currentUserTrial) {
            return null;
        }

        // Validation
        $lastParticipation = $this->participantMainMatchRepository->getAwaitingForUser($user)->first();
        if (!$lastParticipation) {
            throw BaseValidationException::withMessages([
                'participation_not_found' => [
                    __('api_messages.participation_not_found')
                ]
            ]);
        }
        $trialEnd = Carbon::parse($lastParticipation->getDatingDay()->getDatingDate())->endOfDay();
        $userTrial = $this->userTrialFactory->createUserTrial($user, Carbon::now(), $trialEnd);
        return $this->userTrialRepository->save($userTrial);
    }

    /**
     *  Restart user trial
     *
     * @param User $user
     * @return UserTrial
     * @throws Exception
     */
    public function restartTrialIfValid(User $user): ?UserTrial
    {
        // Skip if not eligible user
        $latestUserTrial = $this->userTrialRepository->getLatestTrialByUser($user);
        if ($latestUserTrial?->getStatus() !== TrialStatus::TempCancelled) {
            return null;
        }

        // Validation
        $lastParticipation = $this->participantMainMatchRepository->getAwaitingForUser($user)->first();
        if (!$lastParticipation) {
            throw BaseValidationException::withMessages([
                'participation_not_found' => [
                    __('api_messages.participation_not_found')
                ]
            ]);
        }

        $trialEnd = Carbon::parse($lastParticipation->getDatingDay()->getDatingDate())->endOfDay();
        $userTrial = $this->userTrialFactory->createUserTrial($user, Carbon::now(), $trialEnd);
        return $this->userTrialRepository->save($userTrial);
    }

    /**
     * Temp cancel user trial
     *
     * @param User $user
     * @return UserTrial
     */
    public function tempCancelIfValid(User $user): ?UserTrial
    {
        $latestActiveUserTrial = $this->userTrialRepository->getLatestUserTrialByUserIfActive($user);

        // Skip if not eligible user
        $tempCanceledTrial = $latestActiveUserTrial?->tempCancel();

        return $tempCanceledTrial ? $this->userTrialRepository->save($tempCanceledTrial) : null;
    }

    /**
     * complete Trial
     *
     * @param UserTrial $userTrial
     * @return UserTrial
     */
    public function completeTrial(UserTrial $userTrial): UserTrial
    {
        $user = $this->userRepository->getById($userTrial->getUserId());
        if (
            $user->getStatus() === UserStatus::ApprovedUser
            && $user->getUserPaymentCustomer()
            && $user->getGender() !== UserGender::Female
        ) {
            $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
            $plan = $userPlan->getPlan();
            $this->extSubscriptionRepository->createSubscription($user->getUserPaymentCustomer(), $plan);
            $userTrial->complete();
            $this->userTrialRepository->save($userTrial);
            CompletedTrial::dispatch($user);
        }
        return $userTrial;
    }

}
