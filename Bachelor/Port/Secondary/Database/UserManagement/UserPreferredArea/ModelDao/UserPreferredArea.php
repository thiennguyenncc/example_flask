<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserPreferredArea\ModelDao;

use Bachelor\Domain\UserManagement\UserPreferredArea\Models\UserPreferredArea as UserPreferredAreaDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreferredArea\Traits\UserPreferredAreaRelationshipTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPreferredArea extends BaseModel
{
    use HasFactory, UserPreferredAreaRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_preferred_areas';


    /**
     * @return UserPreferredAreaDomainModel
     */
    public function toDomainEntity(): UserPreferredAreaDomainModel
    {
        $userPreferredArea = new UserPreferredAreaDomainModel(
            $this->user_id,
            $this->area_id,
            $this->priority,
        );
        $userPreferredArea->setId($this->getKey());
        return $userPreferredArea;
    }

    /**
     * @param $userPreferredArea
     * @return UserPreferredArea
     */
    protected function fromDomainEntity($userPreferredArea)
    {
        $this->user_id = $userPreferredArea->getUserId();
        $this->area_id = $userPreferredArea->getAreaId();
        $this->priority = $userPreferredArea->getPriority();
        return $this;
    }
}
