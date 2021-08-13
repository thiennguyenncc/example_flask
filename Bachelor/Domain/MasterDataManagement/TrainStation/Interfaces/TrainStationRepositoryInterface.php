<?php

namespace Bachelor\Domain\MasterDataManagement\TrainStation\Interfaces;

use Bachelor\Domain\MasterDataManagement\TrainStation\Model\TrainStation;
use Illuminate\Support\Collection;

interface TrainStationRepositoryInterface
{

    /**
     * @param int $id
     * @return TrainStation|null
     */
    public function findById(int $id) : ?TrainStation;

    /**
     * @param array $ids
     * @return Collection
     */
    public function getByIds(array $ids): Collection;

    /**
     * @return Collection
     */
    public function getAllTrainStations(): Collection;
}
