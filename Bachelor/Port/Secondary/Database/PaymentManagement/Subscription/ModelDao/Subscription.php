<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Subscription\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription as SubscriptionDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\PaymentManagement\Payment\Traits\SubscriptionRelationshipTrait;
use Bachelor\Port\Secondary\Database\PaymentManagement\Subscription\Trait\HasFactory;
use Carbon\Carbon;

class Subscription extends BaseModel
{
    use SubscriptionRelationshipTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscriptions';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity()
    {
        $model = new SubscriptionDomainEntity(
            $this->userPaymentCustomer()->first()->toDomainEntity(),
            $this->third_party_subscription_id,
            Carbon::make($this->starts_at),
            Carbon::make($this->next_starts_at),
            Carbon::make($this->cancelled_at),
            $this->status
        );
        $model->setId($this->getKey());

        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     * @return Subscription
     */
    protected function fromDomainEntity(BaseDomainModel $model)
    {
        $this->id = $model->getId();
        $this->user_payment_customer_id = $model->getUserPaymentCustomer()->getId();
        $this->third_party_subscription_id = $model->getThirdPartySubscriptionId();
        $this->starts_at = $model->getStartsAt();
        $this->next_starts_at = $model->getNextStartsAt();
        $this->cancelled_at = $model->getCancelledAt();
        $this->status = $model->getStatus();

        return $this;
    }
}
