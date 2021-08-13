<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Plan\Repository;

use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\Plan\ModelDao\Plan as PlanDao;
use Exception;
use Illuminate\Support\Collection;

class EloquentPlanRepository extends EloquentBaseRepository implements PlanRepositoryInterface
{
    /**
     * EloquentPlanRepository constructor.
     * @param PlanDao $plan
     */
    public function __construct(PlanDao $plan)
    {
        parent::__construct($plan);
    }

    /**
     * @param string $key
     * @param string $costPlan
     * @return Plan
     */
    public function getByDiscountCostPlanContract(string $discountType, string $costPlan, int $contractTerm = 1): Plan
    {
        $plan = $this->createQuery()
            ->where('discount_type', $discountType)
            ->where('cost_plan', $costPlan)
            ->where('contract_term', $contractTerm)
            ->first();
        if ($plan) {
            return $plan->toDomainEntity();
        }
        throw new Exception(__('api_messages.plan_not_found'));
    }

    /**
     * @param int $plan_id
     * @return Plan
     */
    public function getPlanById(int $plan_id): Plan
    {
        $plan = $this->createQuery()->find($plan_id);
        if ($plan) {
            return $plan->toDomainEntity();
        }
        throw new Exception(__('api_messages.plan_not_found'));
    }

    /**
     * @param string $thirdPartyPlanid
     * @return Plan|null
     */
    public function getPlanByThirdPartyPlanId(string $thirdPartyPlanid): ?Plan
    {
        $plan = $this->createQuery()
            ->where('third_party_plan_id', $thirdPartyPlanid)
            ->first();

        return optional($plan)->toDomainEntity();
    }


    /**
     * @param string|null $discountType
     * @param string|null $costplan
     * @param int|null $contractTerm
     * @return Collection
     */
    public function getPlanCollection(?string $discountType = null, ?string $costplan = null, ?int $contractTerm = null): Collection
    {
        $query = $this->createQuery();

        if ($discountType) $query->where('discount_type', $discountType);
        if ($costplan) $query->where('cost_plan', $costplan);
        if ($contractTerm) $query->where('contract_term', $contractTerm);

        return $this->transformCollection($query->get());
    }

    /**
     * @param int $perPage
     * @param string|null $discountType
     * @param string|null $costPlan
     * @param int|null $contractTerm
     * @return array
     */
    public function retrievePlanList(int $perPage, ?string $discountType = null, ?string $costPlan = null, ?int $contractTerm = null): array
    {
        $query = $this->createQuery();

        if ($discountType) $query->where('discount_type', $discountType);
        if ($costPlan) $query->where('cost_plan', $costPlan);
        if ($contractTerm) $query->where('contract_term', $contractTerm);

        if ($perPage == 0) {
            return ["data" => $this->transformCollection($query->get())->transform(function (Plan $plan) {
                return [
                    'id' => $plan->getId(),
                    'name' => $plan->getName(),
                    'nickname' => $plan->getNickname(),
                    'third_party_plan_id' => $plan->getThirdPartyPlanId(),
                    'discount_type' => $plan->getDiscountType(),
                    'contract_term' => $plan->getContractTerm(),
                    'cost_plan' => $plan->getCostPlan()->getName(),
                    'final_amount' => $plan->getFinalAmount(),
                    'updated_at' => $plan->getUpdatedAt()->toDateTimeString(),
                ];
            })->toArray()];
        } else {
            return $query->paginate($perPage)->toArray();
        }
    }
    /**
     * Create new plan
     *
     * @param Plan $plan
     * @return Plan
     */
    public function save(Plan $plan): Plan
    {
        return $this->createModelDAO($plan->getId())->saveData($plan);
    }
}
