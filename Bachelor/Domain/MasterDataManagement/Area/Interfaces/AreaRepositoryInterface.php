<?php

namespace Bachelor\Domain\MasterDataManagement\Area\Interfaces;

use Bachelor\Domain\MasterDataManagement\Area\Model\Area;
use Illuminate\Support\Collection;

interface AreaRepositoryInterface
{
    /**
     * @param int $area_id
     * @return Area
     */
    public function getById(int $area_id): ?Area;

    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param $value
     * @param string $column
     * @return Area
     */
    public function getSpecificArea($value, string $column = 'id'): Area;

    /**
     * This is for applying search and filters to the query dynamically to get all required data
     *
     * @param array $params
     * @return Collection
     */
    public function getSpecifiedAreas(array $params): Collection;

    /**
     * This is for applying search and filters to the query dynamically to get all required data
     *
     * @param array $params
     * @return Collection
     */
    public function getAreasByPrefectureId(int $prefectureId): Collection;

    /**
     * Create new dating place
     *
     * @param Area $area
     * @return Area
     */
    public function save(Area $area): Area;

    /**
     * Create new area translation
     *
     * @param Prefecture $prefecture
     * @param array $data
     * @return mixed
     */
    public function updateOrCreatePrefectureTranslation(Area $area, array $data);
}
