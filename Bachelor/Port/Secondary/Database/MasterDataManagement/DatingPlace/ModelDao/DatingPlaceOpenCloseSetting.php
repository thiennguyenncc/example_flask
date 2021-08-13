<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao;

use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceOpenCloseSetting as DatingPlaceOpenCloseSettingDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Traits\DatingPlaceOpenCloseSettingRelationshipTrait;

class DatingPlaceOpenCloseSetting extends BaseModel
{
    use DatingPlaceOpenCloseSettingRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dating_place_open_close_settings';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity()
    {
        $datingPlaceOpenCloseSetting = new DatingPlaceOpenCloseSettingDomainEntity(
            $this->dating_place_id,
            $this->day_of_week,
            $this->open_at,
            $this->close_at
        );

        $datingPlaceOpenCloseSetting->setId($this->id);

        return $datingPlaceOpenCloseSetting;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param \Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceOpenCloseSettingDomainEntity $model
     * @return self
     */
    protected function fromDomainEntity($model): self
    {
        $this->dating_place_id = $model->getDatingPlaceId();
        $this->day_of_week = $model->getDayOfWeek();
        $this->open_at = $model->getOpenAt();
        $this->close_at = $model->getCloseAt();

        return $this;
    }
}
