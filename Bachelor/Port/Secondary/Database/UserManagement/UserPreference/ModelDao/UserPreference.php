<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserPreference\ModelDao;

use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreference\Traits\UserPreferenceRelationshipTrait;
use Bachelor\Port\Secondary\Database\UserManagement\User\Traits\HasFactory;
use Bachelor\Domain\UserManagement\UserPreference\Models\UserPreference as UserPreferenceDomainModel;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;

class UserPreference extends BaseModel
{
    use UserPreferenceRelationshipTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_preference';

    /**
     * @return UserPreferenceDomainModel
     */
    public function toDomainEntity(): UserPreferenceDomainModel
    {
        $userPreference = new UserPreferenceDomainModel(
           $this->user_id,
           $this->age_from,
           $this->age_to,
           $this->height_to,
           $this->height_from,
           $this->partner_body_min,
           $this->partner_body_max,
           $this->smoking,
           $this->drinking,
           $this->divorce,
           $this->annual_income,
           $this->education,
           explode(",",$this->job),
           explode(",",$this->face_preferences),
           $this->appearance_priority,
           $this->first_priority,
           $this->second_priority,
           $this->third_priority,
           $this->hobby
        );
        $userPreference->setId($this->getKey());
        return $userPreference;
    }

    /**
     * @param UserPreferenceDomainModel $userPreference
     * @return UserPreference
     */
    protected function fromDomainEntity($userPreference)
    {
        $this->user_id = $userPreference->getUserId();
        $this->age_from = $userPreference->getAgeFrom();
        $this->age_to = $userPreference->getAgeTo();
        $this->height_to = $userPreference->getHeightTo();
        $this->height_from = $userPreference->getHeightFrom();
        $this->partner_body_min = $userPreference->getPartnerBodyMin();
        $this->partner_body_max = $userPreference->getPartnerBodyMax();
        $this->smoking = $userPreference->getSmoking();
        $this->drinking = $userPreference->getDrinking();
        $this->divorce = $userPreference->getDivorce();
        $this->annual_income = $userPreference->getAnnualIncome();
        $this->education = $userPreference->getEducation();
        $this->job = $userPreference->getJob()? implode(",",$userPreference->getJob()) : null;
        $this->face_preferences = $userPreference->getFacePreferences()? implode(",",$userPreference->getFacePreferences()) : null;
        $this->appearance_priority = $userPreference->getAppearancePriority();
        $this->first_priority = $userPreference->getFirstPriority();
        $this->second_priority = $userPreference->getSecondPriority();
        $this->third_priority = $userPreference->getThirdPriority();
        $this->hobby = $userPreference->getHobby();
        return $this;
    }
}
