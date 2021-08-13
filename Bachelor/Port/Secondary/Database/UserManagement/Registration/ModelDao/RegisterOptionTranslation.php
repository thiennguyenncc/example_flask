<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\Registration\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Traits\RegisterOptionTranslationRelationTrait;
use Bachelor\Domain\MasterDataManagement\RegisterOption\Model\RegisterOptionTranslation as RegisterOptionTranslationDomainModel;

class RegisterOptionTranslation extends BaseModel
{
    use RegisterOptionTranslationRelationTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'register_options_translations';

    /**
     * Create Domain Model object from this model DAO
     * @return RegisterOptionTranslationDomainModel|null
     */
    public function toDomainEntity(): ?RegisterOptionTranslationDomainModel {
        $model = new RegisterOptionTranslationDomainModel(
            $this->register_option_id,
            $this->language_id,
            $this->label_name,
            $this->display_name,
        );
        $model->setId($this->id);
        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param RegisterOptionTranslationDomainModel $model
     */
    protected function fromDomainEntity($model)
    {
        $this->register_option_id = $model->getRegisterOptionId();
        $this->language_id = $model->getLanguageId();
        $this->label_name = $model->getLabelName();
        $this->display_name = $model->getDisplayName();

        return $this;
    }

}
