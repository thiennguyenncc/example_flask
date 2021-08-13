<?php


namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\ModelDao;


use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\Traits\HasFactory;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\Traits\ParticipantAwaitingCountSettingRelationship;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Models\ParticipantAwaitingCountSetting as DomainModel;
class ParticipantAwaitingCountSetting extends BaseModel
{
    use ParticipantAwaitingCountSettingRelationship, HasFactory;

    /**
     * @var string
     */
    protected $table = 'participant_awaiting_count_setting';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'gender',
        'dating_day_id',
        'prefecture_id',
        'type',
        'count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return DomainModel
     */
    public function toDomainEntity()
    {
        $model = new DomainModel(
            $this->dating_day_id,
            $this->gender,
            $this->prefecture_id,
            $this->type,
            $this->count
        );
        $model->setId($this->getKey());

        if ($this->relationLoaded('datingDay')) {
            $model->setDatingDay($this->datingDay()->first()->toDomainEntity());
        }

        return $model;
    }

    /**
     * @param BaseDomainModel $model
     * @return $this
     */
    protected function fromDomainEntity(BaseDomainModel $model)
    {
        $this->dating_day_id = $model->getDatingDayId();
        $this->gender = $model->getGender();
        $this->prefecture_id = $model->getPrefectureId();
        $this->type = $model->getType();
        $this->count = $model->getCount();

        return $this;
    }
}
