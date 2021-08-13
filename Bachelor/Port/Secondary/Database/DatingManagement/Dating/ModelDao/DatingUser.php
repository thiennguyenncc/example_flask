<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao;

use Bachelor\Domain\DatingManagement\Dating\Models\DatingUser as DatingUserDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\Traits\DatingUserRelationshipTrait;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\Traits\HasDatingUserFactory;
use Carbon\Carbon;

class DatingUser extends BaseModel
{
    use DatingUserRelationshipTrait, HasDatingUserFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dating_users';

    /**
     * @return DatingUserDomainEntity
     */
    public function toDomainEntity(): DatingUserDomainEntity
    {
        $datingUser = new DatingUserDomainEntity(
            $this->user()->first()->id,
            $this->dating()->first()->id,
            Carbon::make($this->cancelled_at),
            $this->datingUserCancellForm()->first() ? $this->datingUserCancellForm()->first()->toDomainEntity() : null,

        );
        $datingUser->setId($this->getKey());
        if ($this->relationLoaded('user')) {
            $datingUser->setUser($this->user->toDomainEntity());
        }
        if ($this->relationLoaded('dating')) {
            $datingUser->setDating($this->dating->toDomainEntity());
        }
        return $datingUser;
    }

    /**
     * @param DatingUserDomainEntity $datingUser
     * @return self
     */
    protected function fromDomainEntity($datingUser)
    {
        $this->id = $datingUser->getId();
        $this->user_id = $datingUser->getUserId();
        $this->dating_id = $datingUser->getDatingId();
        $this->cancelled_at = $datingUser->getCancelledAt();

        return $this;
    }
}
