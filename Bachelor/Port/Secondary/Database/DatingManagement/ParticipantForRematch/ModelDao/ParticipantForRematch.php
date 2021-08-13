<?php
namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantForRematch\ModelDao;

use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Models\ParticipantForRematch as ParticipantForRematchDomainEntity;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantForRematch\Traits\ParticipationForRematchRelationshipTrait;

class ParticipantForRematch extends BaseModel
{

    use ParticipationForRematchRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'participants_12pm_matching';

    /**
     *
     * @return ParticipantForRematchDomainEntity
     */
    public function toDomainEntity(): ParticipantForRematchDomainEntity
    {
        $participantForRematch = new ParticipantForRematchDomainEntity($this->user_id, $this->datingDay()
            ->first()
            ->toDomainEntity(), $this->status);

        $participantForRematch->setId($this->getKey());

        return $participantForRematch;
    }

    /**
     *
     * @param ParticipantForRematch $participantForRematch
     * @return ParticipantForRematch
     */
    protected function fromDomainEntity($participantForRematch)
    {
        $this->id = $participantForRematch->getId();
        $this->user_id = $participantForRematch->getUserId();
        $this->dating_day_id = $participantForRematch->getDatingDay()->getId();
        $this->status = $participantForRematch->getStatus();

        return $this;
    }
}
