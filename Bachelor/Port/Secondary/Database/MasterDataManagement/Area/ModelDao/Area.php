<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao;

use Bachelor\Domain\MasterDataManagement\Area\Model\Area as AreaDomain;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\Traits\AreaRelationshipTrait;
use Illuminate\Support\Collection;

class Area extends BaseModel
{
    use AreaRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'areas';

    /**
     * Create Domain Model object from this model DAO
     * @return AreaDomain|null
     */
    public function toDomainEntity() : ?AreaDomain
    {
        $model = new AreaDomain(
            $this->prefecture()->first()->toDomainEntity(),
            $this->name,
            $this->image,
            $this->status,
            $this->areaTranslation()->first()->toDomainEntity(),
        );
        $model->setId($this->getKey());
        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param AreaDomain $model
     * @return Area
     */
    protected function fromDomainEntity($model)
    {
        $this->prefecture_id = $model->getPrefecture()->getId();
        $this->name = $model->getName();
        $this->status = $model->getStatus();
        $this->image = $model->getImage();
        $this->admin_id = $model->getPrefecture()->getAdminId();

        return $this;
    }

}
