<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch as ParticipantMainMatchDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\Traits\HasFactory;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\Traits\ParticipantRelationshipTrait;

class ParticipantMainMatch extends BaseModel
{
    use ParticipantRelationshipTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'participants_main_matching';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'dating_day_id',
        'status',
    ];

    /**
     * @return ParticipantMainMatchDomainModel
     */
    public function toDomainEntity(): ParticipantMainMatchDomainModel
    {
        $model = new ParticipantMainMatchDomainModel(
            $this->user_id,
            $this->dating_day_id,
            $this->status,
            (bool) $this->show_sample_date
        );
        $model->setId($this->getKey());

        if ($this->relationLoaded('user')) {
            $model->setUser($this->user->toDomainEntity());
        }
        if ($this->relationLoaded('datingDay')) {
            $model->setDatingDay($this->datingDay->toDomainEntity());
        }

        return $model;
    }

    /**
     * @param ParticipantMainMatchDomainModel $model
     * @return ParticipantMainMatch
     */
    protected function fromDomainEntity($model)
    {
        $this->id = $model->getId();
        $this->user_id = $model->getUserId();
        $this->dating_day_id = $model->getDatingDayId();
        $this->status = $model->getStatus();
        $this->show_sample_date = (int) $model->isShowSampleDate();

        return $this;
    }
}
