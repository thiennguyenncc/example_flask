<?php


namespace Bachelor\Application\User\Services;

use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Interfaces\MatchInfoGroupInterface;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfo;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfoGroup;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Http\Response;

class UserMatchInfoService
{
    /**
     * @var $matchProfileGroupsRepository
     */
    private $matchProfileGroupsRepository;

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

    /**
     * UserMatchInfoService constructor.
     * @param MatchInfoGroupInterface $matchProfileGroupsRepository
     */
    public function __construct(
        MatchInfoGroupInterface $matchProfileGroupsRepository
    ) {
        $this->matchProfileGroupsRepository = $matchProfileGroupsRepository;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * @param int $age
     * @param int $gender
     *
     * @return $this
     */
    public function filterGroupByAgeAndGender(int $age, int $gender)
    {
        $groups = $this->matchProfileGroupsRepository->filterGroupByAgeAndGender($age, $gender);
        $groups->each(function (MatchInfoGroup $matchInfoGroup) {
            $matchInfoGroup->getMatchInfos()->each(function (MatchInfo $matchInfo) use ($matchInfoGroup) {
                array_push($this->data, [
                    'info_id' => $matchInfo->getId(),
                    'description' => $matchInfo->getDescription(),
                    'image' => Utility::getFileLink($matchInfo->getImage(), config('constants.match_profile_storage_path')),
                    'gender' => $matchInfoGroup->getGender(),
                ]);
            });
        });

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
