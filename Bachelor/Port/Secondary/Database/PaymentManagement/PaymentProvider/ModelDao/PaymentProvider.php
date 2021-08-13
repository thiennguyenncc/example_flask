<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\PaymentProvider\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Models\PaymentProvider as PaymentProviderDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\PaymentManagement\Payment\Traits\PaymentProviderRelationshipTrait;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentProvider\Trait\HasFactory;

class PaymentProvider extends BaseModel
{
    use  PaymentProviderRelationshipTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_providers';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity ()
    {
        $model = new PaymentProviderDomainEntity(
            $this->name
        );
        $model->setId($this->getKey());

        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     * @return PaymentProvider
     */
    protected function fromDomainEntity ( BaseDomainModel $model )
    {
        $this->id = $model->getId();
        $this->name = $model->getName();

        return $this;
    }

}
