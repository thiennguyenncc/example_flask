<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfoGroup as MatchInfoGroupEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\Traits\MatchInfoGroupRelationshipTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class MatchInfoGroup extends BaseModel
{
    use MatchInfoGroupRelationshipTrait;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'match_info_groups';

    protected $with = ['matchInfos'];

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity()
    {
        $matchInfoGroup = new MatchInfoGroupEntity(
            $this->name,
            $this->age_from,
            $this->age_to,
            $this->gender,
            $this->matchInfos->map(function (MatchInfo $matchInfo) {
                return $matchInfo->toDomainEntity();
            }),
        );
        $matchInfoGroup->setId($this->getKey());

        return $matchInfoGroup;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     *
     * @param PrefectureDomainModel $prefecture
     * @return Prefecture
     */
    protected function fromDomainEntity($matchInfoGroup)
    {
        $this->id = $matchInfoGroup->getId();
        $this->name = $matchInfoGroup->getName();
        $this->age_from = $matchInfoGroup->getAgeFrom();
        $this->age_to = $matchInfoGroup->getAgeTo();
        $this->gender = $matchInfoGroup->getGender();

        return $this;
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($group) {
             $group->matchInfos()->delete();
        });
    }
}
