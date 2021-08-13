<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer as UserPaymentCustomerDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\PaymentManagement\Payment\Traits\UserPaymentProviderRelationshipTrait;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\Trait\HasFactory;

class UserPaymentCustomer extends BaseModel
{
    use UserPaymentProviderRelationshipTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_payment_customers';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity()
    {
        $model = new UserPaymentCustomerDomainEntity(
            $this->user_id,
            $this->third_party_customer_id,
            $this->paymentProvider()->first()->toDomainEntity(),
            $this->defaultPaymentCard()->first()?->toDomainEntity(),
        );

        $model->setId($this->getKey());

        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     * @return UserPaymentCustomer
     */
    protected function fromDomainEntity(BaseDomainModel $model)
    {
        $this->id = $model->getId();
        $this->user_id = $model->getUserId();
        $this->third_party_customer_id = $model->getThirdPartyCustomerId();
        $this->payment_provider_id = $model->getPaymentProvider()->getId();
        $this->default_payment_card_id = $model->getDefaultPaymentCard()?->getId();

        return $this;
    }
}
