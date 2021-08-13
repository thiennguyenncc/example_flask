<?php
namespace Bachelor\Port\Secondary\Database\DatingManagement\Matching\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;

class MatchingSetting extends BaseModel
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matching_settings';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity() {

    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     */
    protected function fromDomainEntity($model) {

    }
}
