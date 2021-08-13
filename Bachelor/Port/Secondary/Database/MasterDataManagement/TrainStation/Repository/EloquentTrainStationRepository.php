<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\Repository;

use Bachelor\Domain\MasterDataManagement\TrainStation\Interfaces\TrainStationRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\TrainStation\Model\TrainStation;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\ModelDao\TrainStation as TrainStationDao;
use Illuminate\Support\Collection;

class EloquentTrainStationRepository extends EloquentBaseRepository implements TrainStationRepositoryInterface
{

    /**
     * EloquentTrainStationRepository constructor.
     * @param TrainStationDao $trainStation
     */
    public function __construct(TrainStationDao $trainStation)
    {
        parent::__construct($trainStation);
    }

    /**
     * @param int $id
     * @return TrainStation|null
     */
    public function findById(int $id) : ?TrainStation
    {
        return parent::findById($id);
    }

    /**
     * @param array $ids
     * @return Collection
     */
    public function getByIds(array $ids): Collection
    {
        $trainStations = parent::findByIds($ids)->get();

        return $this->transformCollection($trainStations);
    }

    /**
     * @return Collection
     */
    public function getAllTrainStations(): Collection
    {
        return $this->transformCollection($this->createQuery()->with('trainStationTranslations')->get());
    }
}
