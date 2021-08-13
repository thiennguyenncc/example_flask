<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserPreferredArea\Repository;

use Bachelor\Domain\UserManagement\UserPreferredArea\Interfaces\UserPreferredAreasInterface;
use Bachelor\Domain\UserManagement\UserPreferredArea\Models\UserPreferredArea as UserPreferredAreaDomainModel;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreferredArea\ModelDao\UserPreferredArea;
use Illuminate\Support\Collection;

class EloquentUserPreferredArea extends EloquentBaseRepository implements UserPreferredAreasInterface
{
    /**
     * EloquentUserPreferredArea constructor.
     * @param UserPreferredArea $model
     */
    public function __construct(UserPreferredArea $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return UserPreferredAreaDomainModel|null
     */
    public function getById(int $id): ?UserPreferredAreaDomainModel
    {
        $modelDao = $this->createQuery()->where('id', $id)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param int $userId
     * @param int $areaId
     * @return UserPreferredAreaDomainModel|null
     */
    public function getByUserIdAndAreaId(int $userId, int $areaId): ?UserPreferredAreaDomainModel
    {
        $modelDao = $this->createQuery()->where('user_id', $userId)->where('area_id', $areaId)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param UserPreferredAreaDomainModel $userPreferredPlace
     * @return UserPreferredAreaDomainModel
     */
    public function save(UserPreferredAreaDomainModel $userPreferredPlace): UserPreferredAreaDomainModel
    {
        return $this->createModelDAO($userPreferredPlace->getId())->saveData($userPreferredPlace);
    }

    /**
     * @param int $userId
     * @return Collection|null
     */
    public function retrieveUserPreferredPlaceByUserId(int $userId): ?Collection
    {
        $modelDao = $this->createQuery()->where('user_id', $userId)->get();
        $userPreferredPlacesCollection = new Collection();
        foreach ($modelDao->userPreferredPlaces() as $userPreferredPlace) {
            $userPreferredPlacesCollection->add($userPreferredPlace->toDomainEntity());
        }
        return $userPreferredPlacesCollection;
    }
}
