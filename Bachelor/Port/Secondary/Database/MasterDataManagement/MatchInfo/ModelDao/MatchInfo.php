<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfo as MatchInfoEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\Traits\MatchInfoRelationshipTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchInfo extends BaseModel
{
    use MatchInfoRelationshipTrait;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'match_infos';

    public function toDomainEntity()
    {
        $matchInfo = new MatchInfoEntity(
            $this->group_id,
            $this->description,
            $this->image
        );
        $matchInfo->setId($this->getKey());
        
        return $matchInfo;
    }

    public function fromDomainEntity($model){
        $this->id = $model->getId();
        $this->group_id = $model->getGroupId();
        $this->description = $model->getDescription();
        $this->image = $model->getImage();

        return $this;
    }
}
