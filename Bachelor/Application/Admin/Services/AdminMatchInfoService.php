<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Factories\MatchInfoGroupFactory;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Interfaces\MatchInfoGroupInterface;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfo;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfoGroup;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Http\Response;

class AdminMatchInfoService
{
    /**
     * @var MatchInfoGroupInterface
     */
    private $matchInfoGroupRepository;

    /**
     * @var MatchInfoGroupFactory
     */
    private $matchInfoGroupFactory;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data = [];

    public function __construct(
        MatchInfoGroupInterface $matchInfoGroupRepository,
        MatchInfoGroupFactory $matchInfoGroupFactory
    ) {
        $this->matchInfoGroupRepository = $matchInfoGroupRepository;
        $this->matchInfoGroupFactory = $matchInfoGroupFactory;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get All Profiles
     *
     * @return Array
     */
    public function getAllInfos(): self {
        $groups = $this->matchInfoGroupRepository->getAll();

        $groups->each(function (MatchInfoGroup $matchInfoGroup) {
            $matchInfoGroup->getMatchInfos()->each(function (MatchInfo $matchInfo) use ($matchInfoGroup) {
                array_push($this->data, [
                    'info_id' => $matchInfo->getId(),
                    'description' => $matchInfo->getDescription(),
                    'image' => Utility::getFileLink($matchInfo->getImage(), config('constants.match_profile_storage_path')),
                    'group_id' => $matchInfoGroup->getId(),
                    'group_name' => $matchInfoGroup->getName()
                ]);
            });
        });

        return $this;
    }

    /**
     * Create New Profile
     *
     * @return Array
     */
    public function createGroupAndInfo(array $params): self {
        foreach ($params['info_params_list'] as &$infoParams) {
            $infoParams["image"] = Utility::storeFile(
                $infoParams["image"],
                config('constants.match_profile_storage_path')
            );
        }

        $matchInfoGroup = $this->matchInfoGroupFactory->createMatchInfoGroup($params);
        $this->matchInfoGroupRepository->save($matchInfoGroup);

        return $this;
    }

    /**
     * Update exsting Profile
     *
     * @return Array
     */
    public function updateInfo(int $id, array $params): self {
        $matchInfoGroup = $this->matchInfoGroupRepository->getByInfoId($id);

        $params["image"] = Utility::storeFile(
            $params["image"],
            config('constants.match_profile_storage_path')
        );

        $matchInfoGroup->updateMatchInfoById(
            $id,
            $params['description'],
            $params['image']
        );
        $this->matchInfoGroupRepository->save($matchInfoGroup);

        return $this;
    }

    /**
     * Delete exsting Profile
     *
     * @return Array
     */
    public function deleteGroup(int $id): self {
        $this->matchInfoGroupRepository->deleteGroup($id);

        return $this;
    }

    /**
     * Format response data
     *
     * @return array
     */
    public function handleApiResponse() : array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
