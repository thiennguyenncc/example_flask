<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Plan\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\Plan\Models\Plan as PlanDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\User\Traits\HasFactory;

class Plan extends BaseModel
{
    use HasFactory;

    /**
     * The table associated with the model
     *
     * @var string
     */
    protected $table = 'plans';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity(): PlanDomainEntity
    {
        $plan = new PlanDomainEntity(
            $this->third_party_plan_id,
            $this->name,
            $this->nickname,
            $this->discount_type,
            $this->cost_plan,
            $this->contract_term,
            $this->final_amount,
        );
        $plan->setId($this->getKey());
        $plan->setUpdatedAt($this->updated_at);

        return $plan;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param BaseDomainModel $plan
     * @return Plan
     */
    protected function fromDomainEntity(BaseDomainModel $plan): Plan
    {
        $this->id = $plan->getId();
        $this->third_party_plan_id = $plan->getThirdPartyPlanId();
        $this->name = $plan->getName();
        $this->nickname = $plan->getNickname();
        $this->discount_type = $plan->getDiscountType();
        $this->cost_plan = $plan->getCostPlanKey();
        $this->contract_term = $plan->getContractTerm();
        $this->final_amount = $plan->getFinalAmount();
        return $this;
    }
}
