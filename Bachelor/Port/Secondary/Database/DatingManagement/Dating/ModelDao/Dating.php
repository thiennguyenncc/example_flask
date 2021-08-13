<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao;

use Bachelor\Domain\DatingManagement\Dating\Models\Dating as DatingDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\Traits\DatingRelationshipTrait;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\Traits\HasFactory;
use Carbon\Carbon;

class Dating extends BaseModel
{
    use DatingRelationshipTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dating';

    protected $with = ['datingUsers'];

    /**
     * @return DatingDomainEntity
     */
    public function toDomainEntity(): DatingDomainEntity
    {
        $dating = new DatingDomainEntity(
            $this->datingDay()->first()->toDomainEntity(),
            $this->datingPlace()->first()->id,
            $this->datingUsers->map(function ($datingUser) {
                return $datingUser->toDomainEntity();
            }),
            $this->start_at,
            $this->status,
            $this->created_at
        );
        $dating->setId($this->getKey());
        if ($this->relationloaded('feedbacks')) {
            $dating->setFeedbacks($this->feedbacks()->get()->transform(function ($feedback) {
                return $feedback->toDomainEntity();
            }));
        }

        return $dating;
    }

    /**
     * @param DatingDomainEntity $dating
     * @return self
     */
    protected function fromDomainEntity($dating)
    {
        $this->id = $dating->getId();
        $this->dating_day_id = $dating->getDatingDay()->getId();
        $this->dating_place_id = $dating->getDatingPlaceId();
        $this->start_at = $dating->getStartAt();
        $this->status = $dating->getStatus();

        return $this;
    }
}
