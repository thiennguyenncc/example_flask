<?php

namespace Bachelor\Domain\PaymentManagement\UserPlan\Services;

use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\PaymentManagement\Plan\Services\PlanService;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Enum\UserPlanStatus;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\ExtUserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Models\UserPlan;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Utility\Helpers\Utility;
use Exception;
use Carbon\Carbon;

class UserPlanService
{
    private UserPlanRepositoryInterface $userPlanRepository;

    private PlanService $planService;

    private SubscriptionRepositoryInterface $subscriptionRepository;

    private ExtUserPlanRepositoryInterface $extUserPlanRepository;

    private UserTrialRepositoryInterface $userTrialRepository;

    /**
     * UserPlanService constructor.
     * @param UserPlanRepositoryInterface $userPlanRepository
     * @param UserProfileInterface $userProfileRepository
     * @param PlanRepositoryInterface $planRepository
     */
    public function __construct(
        UserPlanRepositoryInterface $userPlanRepository,
        PlanService $planService,
        SubscriptionRepositoryInterface $subscriptionRepository,
        ExtUserPlanRepositoryInterface $extUserPlanRepository,
        UserTrialRepositoryInterface $userTrialRepository
    ) {
        $this->userPlanRepository = $userPlanRepository;
        $this->planService = $planService;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->extUserPlanRepository = $extUserPlanRepository;
        $this->userTrialRepository = $userTrialRepository;
    }

    /**
     * @param User $user
     * @return UserPlan
     */
    public function createFirstUserPlan(User $user): UserPlan
    {
        $plan = $this->planService->selectFirstPlan($user);

        $newUserPlan = new UserPlan($user->getId(), $plan);

        return $this->userPlanRepository->save($newUserPlan);
    }

    /**
     * @param User $user
     * @param Plan $newPlan
     * @return UserPlan
     */
    public function startNewActivePlan(User $user, Plan $newPlan): UserPlan
    {
        $currentUserPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
        if ($currentUserPlan->getPlan()->getId() === $newPlan->getId()) {
            return $currentUserPlan;
        }

        $currentUserPlan->setStatus(UserPlanStatus::Inactive);
        $this->userPlanRepository->save($currentUserPlan);

        $newUserPlan = new UserPlan($user->getId(), $newPlan);
        return $this->userPlanRepository->save($newUserPlan);
    }

    /**
     * @param User $user
     * @param UserPlan $scheduledUserPlan
     * @param Carbon $activateAt
     * @return UserPlan
     */
    public function activateScheduledPlan(User $user, UserPlan $scheduledUserPlan, Carbon $activateAt): UserPlan
    {
        $currentUserPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());

        //inactivate current user plan
        $currentUserPlan->setStatus(UserPlanStatus::Inactive);
        $this->userPlanRepository->save($currentUserPlan);

        //activate scheduled user plan
        $scheduledUserPlan->setStatus(UserPlanStatus::Active);
        $scheduledUserPlan->setActivateAt($activateAt);
        return $this->userPlanRepository->save($scheduledUserPlan);
    }

    /**
     * @param User $user
     * @param Plan $newPlan
     * @return UserPlan
     */
    public function scheduleNewUserPlan(User $user, Plan $newPlan): UserPlan
    {
        $scheduledUserPlan = $this->userPlanRepository->getScheduledUserPlanByUserId($user->getId());
        if ($scheduledUserPlan) {
            if ($scheduledUserPlan->getPlan()->getId() === $newPlan->getId()) {
                return $scheduledUserPlan;
            }
            $scheduledUserPlan->cancel();
            $this->userPlanRepository->save($scheduledUserPlan);
        }

        $newScheduledUserPlan = new UserPlan($user->getId(), $newPlan, UserPlanStatus::Scheduled);
        return $this->userPlanRepository->save($newScheduledUserPlan);
    }

    /**
     * @param User $user
     * @return UserPlan|null
     */
    public function cancelScheduledUserPlan(User $user): ?UserPlan
    {
        $scheduledUserPlan = $this->userPlanRepository->getScheduledUserPlanByUserId($user->getId());
        if ($scheduledUserPlan) {
            $scheduledUserPlan->cancel();
            return $this->userPlanRepository->save($scheduledUserPlan);
        }
        return null;
    }

    /**
     * Update subscription of a customer
     *
     * @param User $user
     * @param array $params
     * @return array
     */
    public function scheduleNextPlan(User $user, Plan $newPlan): bool
    {
        $subscription = $this->subscriptionRepository->getAppliedSubscription($user);
        if (!$subscription) {
            throw new Exception(__('api_messages.subscription.subscription_not_found'));
        }
        $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());

        $this->extUserPlanRepository->scheduleNextPlan($subscription, $user, $userPlan->getPlan(), $newPlan);

        return Utility::wait(
            function () use ($user, $newPlan) {
                $scheduledUserPlan = $this->userPlanRepository->getScheduledUserPlanByUserId($user->getId());
                return (bool) $scheduledUserPlan->getPlan()->getId() === $newPlan->getId();
            }
        );
    }
}
