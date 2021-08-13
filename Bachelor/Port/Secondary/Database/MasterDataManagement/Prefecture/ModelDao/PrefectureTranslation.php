<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\Traits\PrefectureRelationshipTrait;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\Traits\PrefectureTranslationRelationshipTrait;
use Bachelor\Domain\MasterDataManagement\Prefecture\Model\PrefectureTranslation as PrefectureTranslationDomainModel;

class PrefectureTranslation extends BaseModel
{
    use PrefectureRelationshipTrait, PrefectureTranslationRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'prefecture_translations';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity (): ?PrefectureTranslationDomainModel
    {
        $prefectureTranslation = new PrefectureTranslationDomainModel(
            $this->name,
            $this->prefecture_id,
            $this->language_id,
        );
        $prefectureTranslation->setId($this->getKey());
        return $prefectureTranslation;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $prefectureTranslation
     */
    protected function fromDomainEntity ( $prefectureTranslation )
    {
        $this->id = $prefectureTranslation->getId();
        $this->prefecture_id = $prefectureTranslation->getPrefectureId();
        $this->name = $prefectureTranslation->getName();
        $this->language_id = $prefectureTranslation->getLanguageId();

        return $this;
    }

}
