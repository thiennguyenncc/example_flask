<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Matching\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\Matching\Traits\AwaitingCancelRelationship;

class AwaitingCancel extends BaseModel
{
    use AwaitingCancelRelationship;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matching_awaiting_cancel';

    public function toDomainEntity()
    {

    }

    protected function fromDomainEntity($user)
    {

    }
}
