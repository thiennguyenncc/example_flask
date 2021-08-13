<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Plan\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\UserPlan\Models\UserPlan as UserPlanDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\UserPlan\Traits\UserPlanRelationshipTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class UserPlan extends BaseModel
{
    use HasFactory, UserPlanRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_plan';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity(): UserPlanDomainEntity
    {
        $userPlan = new UserPlanDomainEntity(
            $this->user_id,
            $this->plan()->first()->toDomainEntity(),
            $this->status,
            Carbon::make($this->activate_at)
        );
        $userPlan->setId($this->getKey());

        return $userPlan;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     * @return UserPlan
     */
    protected function fromDomainEntity(BaseDomainModel $model)
    {
        $this->id = $model->getId();
        $this->user_id = $model->getUserId();
        $this->plan_id = $model->getPlan()->getId();
        $this->status = $model->getStatus();
        $this->activate_at = $model->getActivateAt();

        return $this;
    }

    /**
     * @return mixed
     */
    protected function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
