<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\ModelDao;

use Bachelor\Domain\MasterDataManagement\TrainStation\Model\TrainStation as TrainStationDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\Traits\TrainStationRelationshipTrait;

class TrainStation extends BaseModel
{
    use TrainStationRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'train_stations';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [ 'defaultTrainStationTranslation' ];

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity ()
    {
        $trainStation = new TrainStationDomainEntity(
            (int)$this->googleTrainStationId,
            $this->trainStationTranslations()->get()->transform(function ($trainStation) {
                return $trainStation->toDomainEntity();
            })
        );
        $trainStation->setId($this->id);
        $trainStation->setDefaultTrainStationTranslation($this->defaultTrainStationTranslation->first()->toDomainEntity());

        return $trainStation;

    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param TrainStationDomainEntity $model
     * @return TrainStation
     */
    protected function fromDomainEntity($model): TrainStation
    {
        $this->google_train_station_id = $model->getGoogleTrainStationId();

        return $this;
    }

}
