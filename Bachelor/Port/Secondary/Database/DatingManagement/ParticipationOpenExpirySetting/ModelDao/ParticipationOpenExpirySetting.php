<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipationOpenExpirySetting\ModelDao;

use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Model\ParticipationOpenExpirySetting as ParticipationOpenExpirySettingDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipationOpenExpirySetting\Traits\HasFactory;

class ParticipationOpenExpirySetting extends BaseModel
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'participation_open_expiry_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'dating_day_of_week',
        'is_user_2nd_form_completed',
        'user_gender',
        'open_days_before_dating_date',
        'expiry_days_before_dating_date',
    ];

    /**
     * @return ParticipationOpenExpirySettingDomainModel
     */
    public function toDomainEntity(): ParticipationOpenExpirySettingDomainModel
    {
        $model = new ParticipationOpenExpirySettingDomainModel(
            $this->dating_day_of_week,
            $this->is_user_2nd_form_completed,
            $this->user_gender,
            $this->open_days_before_dating_date,
            $this->expiry_days_before_dating_date
        );
        $model->setId($this->getKey());
        return $model;
    }

    /**
     * @param ParticipationOpenExpirySettingDomainModel $model
     * @return ParticipationOpenExpirySetting
     */
    protected function fromDomainEntity($model)
    {
        $this->id = $model->getId();
        $this->dating_day_of_week = $model->getDatingDayOfWeek();
        $this->is_user_2nd_form_completed = $model->getIsUser2ndFormCompleted();
        $this->user_gender = $model->getUserGender();
        $this->open_days_before_dating_date = $model->getOpenDaysBeforeDatingDate();
        $this->expiry_days_before_dating_date = $model->getExpiryDaysBeforeDatingDate();

        return $this;
    }
}
