<?php

namespace Bachelor\Domain\PaymentManagement\Plan\Services;

use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\PaymentManagement\Plan\Enum\DiscountType;
use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserProfile\Enums\AnnualIncome;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;

class PlanService
{
    /**
     * @var PlanRepositoryInterface
     */
    private PlanRepositoryInterface $planRepository;

    /**
     * @var UserProfileInterface
     */
    private UserProfileInterface $userProfileRepository;

    /**
     * PlanService constructor.
     * @param PlanRepositoryInterface $planInterface
     */
    public function __construct(PlanRepositoryInterface $planRepository, UserProfileInterface $userProfileRepository)
    {
        $this->planRepository = $planRepository;
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * select First Plan
     *
     * @param User $user
     * @return Plan
     */
    public function selectFirstPlan(User $user): Plan
    {
        $discount_type = DiscountType::NoDiscount;
        $cost_plan = CostPlan::Light;
        $contractTerm = 1;

        $userProfile = $this->userProfileRepository->retrieveUserProfileByUserId($user->getId());

        //use this when enable young discount
        // if ($userProfile->getAge() <= 25) $discount_type = DiscountType::Young;

        if ($userProfile->getAnnualIncome() >= AnnualIncome::TenToFifteen) {
            $cost_plan = CostPlan::Premium;
        } elseif ($userProfile->getAnnualIncome() >= AnnualIncome::SixToEight) {
            $cost_plan = CostPlan::Normal;
        }

        return $this->planRepository->getByDiscountCostPlanContract($discount_type, $cost_plan, $contractTerm);
    }
}
