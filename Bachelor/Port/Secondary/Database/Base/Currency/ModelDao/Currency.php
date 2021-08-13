<?php

namespace Bachelor\Port\Secondary\Database\Base\Currency\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\Base\Currency\Traits\CurrencyRelationshipTrait;

class Currency extends BaseModel
{
    use CurrencyRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'currencies';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity ()
    {
        // TODO: Implement toDomainEntity() method.
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     */
    protected function fromDomainEntity ( BaseDomainModel $model )
    {
        // TODO: Implement fromDomainEntity() method.
    }

}
