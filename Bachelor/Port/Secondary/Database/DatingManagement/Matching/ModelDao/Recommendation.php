<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Matching\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\Matching\Traits\RecommendationRelationship;

class Recommendation extends BaseModel
{
    use RecommendationRelationship;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'matching_recommendation';

    public function toDomainEntity()
    {

    }

    protected function fromDomainEntity($user)
    {

    }
}
