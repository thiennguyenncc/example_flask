<?php
namespace Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Factories;

use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfo;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfoGroup;

class MatchInfoGroupFactory
{
    /**
     * @param array $groupParams
     * @param array $infoParamsList
     * @return MatchInfoGroup
     */
    public function createMatchInfoGroup(array $params) : MatchInfoGroup
    {
        $infos = collect();

        foreach ($params['info_params_list'] as $infoParams) {
            $infos->push(
                new MatchInfo(
                    NULL,
                    $infoParams['description'],
                    $infoParams['image']
                )
            );
        }

        return new MatchInfoGroup(
            $params['name'],
            $params['ageFrom'],
            $params['ageTo'],
            $params['gender'],
            $infos
        );
    }
}
