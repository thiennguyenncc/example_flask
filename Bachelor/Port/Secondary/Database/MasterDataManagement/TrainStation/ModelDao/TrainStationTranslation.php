<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\MasterDataManagement\TrainStation\Model\TrainStationTranslation as TrainStationTranslationDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\Traits\TrainStationTranslationRelationshipTrait;

class TrainStationTranslation extends BaseModel
{
    use TrainStationTranslationRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'train_stations_translations';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity ()
    {
        $trainStationTranslation = new TrainStationTranslationDomainEntity(
            (int)$this->trainStationId,
            (int)$this->languageId,
            (string)$this->name
        );
        $trainStationTranslation->setId($this->id);

        return $trainStationTranslation;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     */
    protected function fromDomainEntity ( BaseDomainModel $model )
    {
        // TODO: Implement fromDomainEntity() method.
    }

}
