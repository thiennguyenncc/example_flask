<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Category\ModelDao;

use Bachelor\Domain\MasterDataManagement\StarCategory\Models\StarCategory as StarCategoryDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Category\Traits\StarCategoryRelationshipTrait;

class StarCategory extends BaseModel
{
    use StarCategoryRelationshipTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'star_categories';

    public function toDomainEntity(): StarCategoryDomainModel
    {
        $starCategory = new StarCategoryDomainModel(
            (string)$this->label,
            (int)$this->status
        );
        $starCategory->setId($this->getKey());

        return $starCategory;
    }

    /**
     * @param StarCategoryDomainModel $starCategory
     */
    protected function fromDomainEntity($starCategory)
    {
        $this->id = $starCategory->getId();
        $this->label = $starCategory->getLabel();
        $this->status = $starCategory->getStatus();

        return $this;
    }
}
