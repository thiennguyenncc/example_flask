<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\Traits\AreaTranslationRelationshipTrait;
use Bachelor\Domain\MasterDataManagement\Area\Model\AreaTranslation as AreaTranslationDomainModel;

class AreaTranslation extends BaseModel
{
    use AreaTranslationRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'area_translations';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity (): ?AreaTranslationDomainModel
    {
        $model = new AreaTranslationDomainModel(
            $this->area_id,
            $this->language_id,
            $this->name
        );
        $model->setId($this->id);
        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param AreaTranslationDomainModel $model
     */
    protected function fromDomainEntity ( $model )
    {
        $this->area_id = $model->getAreaId();
        $this->language_id = $model->getLanguageId();
        $this->name = $model->getName();
    }

}
