<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao;
use Bachelor\Domain\UserManagement\UserProfile\Models\UserProfile as UserProfileDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\Traits\UserProfileRelationshipTrait;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\Traits\HasFactory;
use Carbon\Carbon;

class UserProfile extends BaseModel
{
    use UserProfileRelationshipTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_profile';

    /**
     * @return UserProfileDomainModel
     */
    public function toDomainEntity(): UserProfileDomainModel
    {
        $userProfile = new UserProfileDomainModel(
            $this->user_id,
            Carbon::make($this->birthday),
            (int)$this->height,
            (int)$this->body_type,
            (int)$this->marriage_intention,
            explode(",",$this->character),
            (int)$this->smoking,
            (int)$this->drinking,
            (int)$this->divorce,
            (int)$this->annual_income,
            explode(",",$this->appearance_strength),
            explode(",",$this->appearance_features),
            (int) $this->education,
            optional($this->school()->first())->toDomainEntity(),
            $this->company_name,
            (int)$this->job,
            explode(",",$this->hobby)
        );
        $userProfile->setId($this->getKey());

        if ($this->relationLoaded('user')) {
            $userProfile->setUser($this->user()->first()->toDomainEntity());
        }

        return $userProfile;
    }

    /**
     * @param UserProfileDomainModel $userProfile
     * @return UserProfile
     */
    protected function fromDomainEntity($userProfile)
    {
        $this->user_id = $userProfile->getUserId();
        $this->birthday = $userProfile->getBirthDay();
        $this->height = $userProfile->getHeight();
        $this->body_type = $userProfile->getBodyType();
        $this->marriage_intention = $userProfile->getMarriageIntention();
        $this->character = $userProfile->getCharacter()? implode(",",$userProfile->getCharacter()) : NUll;
        $this->smoking = $userProfile->getSmoking();
        $this->drinking = $userProfile->getDrinking();
        $this->divorce = $userProfile->getDivorce();
        $this->annual_income = $userProfile->getAnnualIncome();
        $this->appearance_strength = $userProfile->getAppearanceStrength()? implode(",",$userProfile->getAppearanceStrength()) : NUll;
        $this->appearance_features = $userProfile->getAppearanceFeatures()? implode(",",$userProfile->getAppearanceFeatures()) :NULL;
        $this->education = $userProfile->getEducation();
        $this->school_id = $userProfile->getSchool()? $userProfile->getSchool()->getId() :NUll;
        $this->company_name = $userProfile->getCompanyName();
        (int)$this->job = $userProfile->getJob();
        $this->hobby = $userProfile->getHobby()? implode(",",$userProfile->getHobby()) :NULL;
        return $this;
    }
}
