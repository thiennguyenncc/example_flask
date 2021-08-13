<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao;

use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlace as DatingPlaceDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Traits\DatingPlaceRelationshipTrait;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Traits\HasFactory;

class DatingPlace extends BaseModel
{
    use DatingPlaceRelationshipTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dating_places';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity()
    {
        $datingPlace = new DatingPlaceDomainEntity(
            (int)$this->area_id,
            (string)$this->category,
            (float)$this->latitude,
            (float)$this->longitude,
            (float)$this->rating,
            (string)$this->displayPhone,
            (string)$this->phone,
            (int)$this->status,
            (int)$this->train_station_id,
            (string)$this->reference_page_link,
            (string)$this->image,
            $this->datingPlaceTranslations()->get()->transform(function ($datingPlaceTranslation) {
                return $datingPlaceTranslation->toDomainEntity();
            }),
            $this->datingPlaceOpenCloseSettings()->get()->transform(function ($datingPlaceOpenCloseSetting) {
                return $datingPlaceOpenCloseSetting->toDomainEntity();
            })
        );
        $datingPlace->setId($this->id);
        $datingPlace->setDatingPlaceTranslation($this->datingPlaceTranslation()->first()->toDomainEntity());
        $datingPlace->setTrainStation($this->trainStation()->first()->toDomainEntity());

        return $datingPlace;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param \Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlace $model
     * @return DatingPlace
     */
    protected function fromDomainEntity($model)
    {
        $this->area_id = $model->getAreaId();
        $this->category = $model->getCategory();
        $this->latitude = $model->getLatitude();
        $this->longitude = $model->getLongitude();
        $this->rating = $model->getRating();
        $this->display_phone = $model->getDisplayPhone();
        $this->phone = $model->getPhone();
        $this->status = $model->getStatus();
        $this->train_station_id = $model->getTrainStationId();
        $this->reference_page_link = $model->getReferencePageLink();
        $this->image = $model->getImage();

        return $this;
    }
}
