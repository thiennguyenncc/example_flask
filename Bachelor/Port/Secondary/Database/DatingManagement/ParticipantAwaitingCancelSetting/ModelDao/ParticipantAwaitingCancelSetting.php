<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCancelSetting\ModelDao;

use Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Models\ParticipantAwaitingCancelSetting as DomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCancelSetting\Traits\ParticipantAwaitingCancelSettingRelationship;

class ParticipantAwaitingCancelSetting extends BaseModel
{
    use ParticipantAwaitingCancelSettingRelationship;

    /**
     * @var string
     */
    protected $table = 'participant_awaiting_cancel_setting';

    /**
     * @return DomainModel
     */
    public function toDomainEntity(): DomainModel
    {
        $model = new DomainModel(
            $this->dating_day_id,
            $this->gender,
            $this->days_before,
            $this->ratio
        );
        $model->setId($this->getKey());

        if ($this->relationLoaded('datingDay')) {
            $model->setDatingDay($this->datingDay()->first()->toDomainEntity());
        }
        return $model;
    }

    /**
     * @param DomainModel $model
     * @return ParticipantAwaitingCancelSetting
     */
    protected function fromDomainEntity($model)
    {
        $this->dating_day_id = $model->getDatingDayId();
        $this->gender = $model->getGender();
        $this->days_before = $model->getDaysBefore();
        $this->ratio = $model->getRatio();

        return $this;
    }
}
