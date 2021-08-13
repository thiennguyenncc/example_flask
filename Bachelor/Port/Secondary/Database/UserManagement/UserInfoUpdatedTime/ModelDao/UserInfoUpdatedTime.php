<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\ModelDao;

use Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Models\UserInfoUpdatedTime as UserInfoUpdatedTimeDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\Traits\UserInfoUpdatedTimeRelationshipTrait;
use Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\Traits\HasFactory;
use Carbon\Carbon;

class UserInfoUpdatedTime extends BaseModel
{
    use UserInfoUpdatedTimeRelationshipTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_info_updated_time';

    /**
     * @return UserInfoUpdatedTimeDomainModel
     */
    public function toDomainEntity(): UserInfoUpdatedTimeDomainModel
    {
        $userInfoUpdatedTime = new UserInfoUpdatedTimeDomainModel(
            $this->user_id,
            Carbon::make($this->approved_at),
            Carbon::make($this->first_registration_completed_at),
        );
        $userInfoUpdatedTime->setId($this->getKey());

        if ($this->relationLoaded('user')) {
            $userInfoUpdatedTime->setUser($this->user()->first()->toDomainEntity());
        }

        return $userInfoUpdatedTime;
    }

    /**
     * @param UserInfoUpdatedTimeDomainModel $userInfoUpdatedTime
     * @return UserInfoUpdatedTime
     */
    protected function fromDomainEntity($userInfoUpdatedTime)
    {
        $this->id = $userInfoUpdatedTime->getId();
        $this->user_id = $userInfoUpdatedTime->getUserId();
        $this->approved_at = $userInfoUpdatedTime->getApprovedAt();
        $this->first_registration_completed_at = $userInfoUpdatedTime->getFirstRegistrationCompletedAt();

        return $this;
    }
}
