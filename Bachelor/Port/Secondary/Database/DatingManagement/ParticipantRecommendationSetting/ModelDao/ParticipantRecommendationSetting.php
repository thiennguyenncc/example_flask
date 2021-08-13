<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantRecommendationSetting\ModelDao;

use Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Models\ParticipantRecommendationSetting as DomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantRecommendationSetting\Traits\ParticipantRecommendationSettingRelationship;

class ParticipantRecommendationSetting extends BaseModel
{
    use ParticipantRecommendationSettingRelationship;

    /**
     * @var string
     */
    protected $table = 'participant_recommendation_setting';

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
     * @return ParticipantRecommendationSetting
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
