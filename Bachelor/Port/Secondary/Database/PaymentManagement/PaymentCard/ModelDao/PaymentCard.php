<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard as PaymentCardDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\Trait\HasFactory;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\ModelDao\UserPaymentCustomer;

class PaymentCard extends BaseModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_cards';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity()
    {
        $model = new PaymentCardDomainEntity(
            $this->userPaymentCustomer()->first()->id,
            $this->third_party_card_id,
            $this->card_last_four_digits
        );
        $model->setId($this->getKey());

        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     * @return PaymentCard
     */
    protected function fromDomainEntity(BaseDomainModel $model)
    {
        $this->id = $model->getId();
        $this->user_payment_customer_id = $model->getUserPaymentCustomerId();
        $this->third_party_card_id = $model->getThirdPartyCardId();
        $this->card_last_four_digits = $model->getLastFourDigits();

        return $this;
    }

    /**
     * @return mixed
     */
    protected function userPaymentCustomer()
    {
        return $this->belongsTo(UserPaymentCustomer::class, 'user_payment_customer_id');
    }
}
