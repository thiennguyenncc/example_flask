<?php

namespace Bachelor\Domain\PaymentManagement\Plan\Interfaces;

use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Illuminate\Support\Collection;

interface PlanRepositoryInterface
{
    /**
     * @param string $key
     * @param string $costPlan
     * @return Plan
     */
    public function getByDiscountCostPlanContract(string $type, string $costPlan, int $contractTerm): Plan;

    /**
     * @param int $plan_id
     * @return Plan
     */
    public function getPlanById(int $planId): Plan;

    /**
     * @param string $thirdPartyPlanId
     * @return Plan|null
     */
    public function getPlanByThirdPartyPlanId(string $thirdPartyPlanId): ?Plan;

    /**
     * @param string|null $discountType
     * @param string|null $costPlan
     * @param int|null $contractTerm
     * @return Collection
     */
    public function getPlanCollection(?string $discountType = null, ?string $costPlan = null, ?int $contractTerm = null): Collection;

    /**
     * @param int $perpage
     * @param string|null $discountType
     * @param string|null $costPlan
     * @param int|null $contractTerm
     * @return array
     */
    public function retrievePlanList(int $perpage, ?string $discountType = null, ?string $costPlan = null, ?int $contractTerm = null): array;

    /**
     * Create new plan
     *
     * @param Plan $plan
     * @return mixed
     */
    public function save(Plan $plan): Plan;
}
