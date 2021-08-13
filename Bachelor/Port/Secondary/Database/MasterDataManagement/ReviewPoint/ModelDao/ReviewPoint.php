<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewPoint\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\MasterDataManagement\ReviewPoint\Models\ReviewPoint as ReviewPointDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewPoint\Traits\ReviewPointRelationshipTrait;

class ReviewPoint extends BaseModel
{
    use ReviewPointRelationshipTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'review_points';

    public function toDomainEntity(): ReviewPointDomainModel
    {
        $reviewPoint = new ReviewPointDomainModel(
            (string)$this->label,
            (int)$this->key,
            (int)$this->status
        );
        $reviewPoint->setId($this->getKey());

        return $reviewPoint;
    }

    /**
     * @param ReviewPointDomainModel $reviewPoint
     * @return $this
     */
    protected function fromDomainEntity($reviewPoint)
    {
        $this->label = $reviewPoint->getLabel();
        $this->key = $reviewPoint->getKey();
        $this->status = $reviewPoint->getStatus();

        return $this;
    }
}
