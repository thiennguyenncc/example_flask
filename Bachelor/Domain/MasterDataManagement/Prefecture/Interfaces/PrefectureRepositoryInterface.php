<?php

namespace Bachelor\Domain\MasterDataManagement\Prefecture\Interfaces;

use Bachelor\Domain\MasterDataManagement\Prefecture\Model\Prefecture;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\PrefectureTranslation;
use Illuminate\Support\Collection;

interface PrefectureRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllPrefectures(): Collection;

    /**
     * @param $value
     * @param string $column
     * @return Prefecture|null
     */
    public function getSpecificPrefecture($value, string $column = 'id'): ?Prefecture;

    /**
     * This is for applying search and filters to the query dynamically to get all required data
     *
     * @param array $params
     * @return Collection
     */
    public function getSpecifiedPrefectures(array $params): Collection;

    /**
     * Create new prefecture
     *
     * @param Prefecture $prefecture
     * @return Prefecture
     */
    public function save(Prefecture $prefecture): Prefecture;

    /**
     * Create new register option translation
     *
     * @param Prefecture $model
     * @param array $data
     * @return mixed
     */
    public function updateOrCreatePrefectureTranslation(Prefecture $model, array $data);

    /**
     * @param int $status
     * @return Collection
     */
    public function getPrefectureCollectionByStatus(int $status): Collection;
}
