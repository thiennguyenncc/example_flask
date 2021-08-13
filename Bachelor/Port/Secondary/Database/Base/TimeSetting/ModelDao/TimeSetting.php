<?php

namespace Bachelor\Port\Secondary\Database\Base\TimeSetting\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;

class TimeSetting extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'time_settings';

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
