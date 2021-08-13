<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceTranslation as DatingPlaceTranslationDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Traits\DatingPlaceTranslationRelationshipTrait;

class DatingPlaceTranslation extends BaseModel
{
    use DatingPlaceTranslationRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dating_place_translations';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity()
    {
        $datingPlaceTranslation = new DatingPlaceTranslationDomainEntity(
            (int)$this->dating_place_id,
            (int)$this->language_id,
            (string)$this->name,
            (string)$this->display_address,
            (string)$this->zip_code
        );

        $datingPlaceTranslation->setId($this->id);

        return $datingPlaceTranslation;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param \Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceTranslation $model
     * @return DatingPlaceTranslation
     */
    protected function fromDomainEntity ($model)
    {
        $this->dating_place_id = $model->getDatingPlaceId();
        $this->language_id = $model->getLanguageId();
        $this->name = $model->getName();
        $this->display_address = $model->getDisplayAddress();
        $this->zip_code = $model->getZipCode();

        return $this;
    }

}
