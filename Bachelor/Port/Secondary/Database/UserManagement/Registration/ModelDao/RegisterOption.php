<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\Registration\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Traits\RegisterOptionRelationshipTrait;
use Bachelor\Domain\MasterDataManagement\RegisterOption\Model\RegisterOption as RegisterOptionDomainModel;

class RegisterOption extends BaseModel
{
    use RegisterOptionRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'register_options';

    /**
     * Create Domain Model object from this model DAO
     * @return RegisterOptionDomainModel|null
     */
    public function toDomainEntity(): ?RegisterOptionDomainModel {
        $model = new RegisterOptionDomainModel(
            $this->option_key,
            $this->option_value,
            $this->type,
            $this->allowed_gender,
            $this->sort,
            $this->status,
            $this->registerOptionsTranslations()->first()?->toDomainEntity(),
        );
        $model->setId($this->id);
        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param RegisterOptionDomainModel $model
     */
    protected function fromDomainEntity($model) {
        $this->option_key = $model->getOptionKey();
        $this->option_value = $model->getOptionValue();
        $this->type = $model->getType();
        $this->allowed_gender = $model->getAllowedGender();
        $this->sort = $model->getSort();
        $this->status = $model->getStatus();

        return $this;
    }
}
