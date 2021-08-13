<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\UserTrial\Models\UserTrial as UserTrialDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\PaymentManagement\Payment\Traits\UserTrialRelationshipTrait;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\Trait\HasFactory;
use Carbon\Carbon;

class UserTrial extends BaseModel
{
    use HasFactory, UserTrialRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_trials';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity()
    {
        $model = new UserTrialDomainEntity(
            $this->user_id,
            Carbon::make($this->trial_start),
            Carbon::make($this->trial_end),
            $this->status
        );

        $model->setId($this->getKey());

        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $userTrial
     */
    protected function fromDomainEntity(BaseDomainModel $userTrial)
    {
        $this->id = $userTrial->getId();
        $this->user_id = $userTrial->getUserId();
        $this->trial_start = $userTrial->getTrialStart();
        $this->trial_end = $userTrial->getTrialEnd();
        $this->status = $userTrial->getStatus();
    }
}
