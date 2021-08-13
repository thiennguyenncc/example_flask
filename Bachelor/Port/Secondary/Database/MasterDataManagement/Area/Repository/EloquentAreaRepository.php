<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Area\Repository;

use Bachelor\Domain\MasterDataManagement\Area\Model\Area;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao\Area as AreaDao;
use Bachelor\Domain\MasterDataManagement\Area\Interfaces\AreaRepositoryInterface;
use Illuminate\Support\Collection;

class EloquentAreaRepository extends EloquentBaseRepository implements AreaRepositoryInterface
{
    /**
     * EloquentAreaRepository constructor.
     * @param AreaDao $area
     */
    public function __construct(AreaDao $area)
    {
        parent::__construct($area);
    }

    /**
     * @param $value
     * @param string $column
     * @return Area
     */
    public function getSpecificArea($value, string $column = 'id'): Area
    {
        return $this->modelDAO->where($column, $value)->first()->toDomainEntity();
    }

    /**
     * @param int $area_id
     * @return ?Area
     */
    public function getById(int $area_id): ?Area
    {
        return $this->modelDAO->find($area_id)->toDomainEntity();
    }

    /**
     * Create new area
     *
     * @param Area $area
     * @return Area
     */
    public function save(
        Area $area
    ): Area {
        return $this->createModelDAO($area->getId())->saveData($area);
    }

    /**
     * This is for applying search and filters to the query dynamically to get all required data
     *
     * @param array $params
     * @return Collection
     */
    public function getSpecifiedAreas(array $params): Collection
    {
        return $this->getSpecificDomainModelCollections($params);
    }

    /**
     * @param int $prefectureId
     * @return Collection
     */
    public function getAreasByPrefectureId(int $prefectureId): Collection
    {
        $modelDao = $this->createModelDAO()->with('areaTranslations')->where('prefecture_id', $prefectureId);
        return $this->transformCollection($modelDao->get());
    }

    /**
     * Create new area translation
     *
     * @param Prefecture $prefecture
     * @param array $data
     * @return mixed
     */
    public function updateOrCreatePrefectureTranslation(Area $area, array $data)
    {
        $areaDao = $this->createModelDAO($area->getId());

        return $areaDao->areaTranslations()->updateOrCreate($data);
    }
}
