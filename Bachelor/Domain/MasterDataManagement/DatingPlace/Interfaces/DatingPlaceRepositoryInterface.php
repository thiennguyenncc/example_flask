<?php

namespace Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces;

use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlace;
use Illuminate\Support\Collection;

interface DatingPlaceRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllDatingPlaces() : Collection;

    /**
     * @param $value
     * @param string $column
     * @return DatingPlace
     */
    public function getSpecificDatingPlace($value, string $column = 'id') : DatingPlace;

    /**
     * This is for applying search and filters to the query dynamically to get all required data
     *
     * @param array $params
     * @return Collection
     */
    public function getSpecifiedDatingPlaces(array $params) : Collection;

    /**
     * Create new dating place
     *
     * @param DatingPlace $datingPlace
     * @return DatingPlace
     */
    public function save(DatingPlace $datingPlace): DatingPlace;

    /**
     * @param int $trainStationId
     * @param string $category
     * @param array $exceptDatingPlaceIds
     * @return Collection
     */
    public function getThreeDatingPlaceByTrainStationId(int $trainStationId, string $category, array $exceptDatingPlaceIds = []): Collection;

    /**
     * @param $id
     * @return DatingPlace
     */
    public function getById($id): DatingPlace;

    /**
     * @param array $ids
     * @return Collection
     */
    public function getByIds(array $ids): Collection;

    /**
     * @return Collection
     */
    public function getDatingPlaces(): Collection;
}
