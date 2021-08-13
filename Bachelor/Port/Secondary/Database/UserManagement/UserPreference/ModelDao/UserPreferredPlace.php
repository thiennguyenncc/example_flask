<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserPreference\ModelDao;

use Bachelor\Domain\UserManagement\UserPreference\Models\UserPreferredPlace as UserPreferredPlaceDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreference\Traits\UserPreferredPlaceRelationshipTrait;

class UserPreferredPlace extends BaseModel
{
    use UserPreferredPlaceRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_preferred_places';

    /**
     * @return UserPreferredPlaceDomainModel
     */
    public function toDomainEntity(): UserPreferredPlaceDomainModel
    {
        $userPreferredPlace = new UserPreferredPlaceDomainModel(
            $this->user_id,
            $this->area_id,
            $this->priority,
        );
        $userPreferredPlace->setId($this->getKey());
        return $userPreferredPlace;
    }

    /**
     * @param UserPreferredPlaceDomainModel $userPreferredPlace
     * @return UserPreferredPlace
     */
    protected function fromDomainEntity($userPreferredPlace)
    {
        $this->user_id = $userPreferredPlace->getUserId();
        $this->area_id = $userPreferredPlace->getAreaId();
        $this->priority = $userPreferredPlace->getPriority();
        return $this;
    }
}
