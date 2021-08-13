<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\Repository;

use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Interfaces\MatchInfoGroupInterface;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfo;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfoGroup;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\ModelDao\MatchInfo as ModelDaoMatchInfo;
use Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\ModelDao\MatchInfoGroup as MatchInfoGroupDao;
use Illuminate\Support\Collection;

class EloquentMatchInfoGroupRepository extends EloquentBaseRepository implements MatchInfoGroupInterface
{
    /**
     * @param MatchInfoGroupDao $matchInfoGroup
     */
    public function __construct(MatchInfoGroupDao $matchInfoGroupDao)
    {
        parent::__construct($matchInfoGroupDao);
    }


    public function getByInfoId(int $id): MatchInfoGroup {
        $group = $this->model
            ->whereHas('matchInfos', function ($query) use ($id) {
                return $query->where('id', $id);
            })->first();

        return $group->toDomainEntity();
    }

    /**
     * @param MatchInfoGroup $dating
     * @return MatchInfoGroup
     */
    public function save(MatchInfoGroup $matchInfoGroup): MatchInfoGroup
    {
        $matchInfoGroupWithId = $this->createModelDAO($matchInfoGroup->getId())->saveData($matchInfoGroup);

        $infos = $matchInfoGroup->getMatchInfos();

        $infos->map(function (
            MatchInfo $matchInfo
        ) use ($matchInfoGroupWithId) {
            $matchInfo->setGroupId($matchInfoGroupWithId->getId());
            $matchInfoDAO = new ModelDaoMatchInfo();
            return $matchInfoDAO->saveData($matchInfo);
        });

        $matchInfoGroupWithId->setMatchInfos($infos);

        return $matchInfoGroupWithId;
    }

    /**
     * Delete exsting Group
     *
     * @return bool
     */
    public function deleteGroup(int $id): bool {
        $this->model->find($id)->delete();

        return true;
    }

    /**
     * Filter group by age and gender
     *
     * @param int $age
     * @param int $gender
     *
     * @return Collection
     */
    public function filterGroupByAgeAndGender(int $age, int $gender): Collection
    {
        $query = $this->model->newQuery();
        $query->where('age_from', '<=', $age)
            ->where('age_to', '>=', $age)
            ->where('gender', '=', $gender);
        $group = $query->orderBy('age_from')->limit(1)->get();

        return $this->transformCollection($group);
    }

}
