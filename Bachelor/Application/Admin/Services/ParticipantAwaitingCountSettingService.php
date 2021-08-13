<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Application\Admin\Services\Interfaces\ParticipantAwaitingCountSettingServiceInterface;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Enums\AwaitingCountType;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Interfaces\ParticipantAwaitingCountSettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Models\ParticipantAwaitingCountSetting;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class ParticipantAwaitingCountSettingService implements ParticipantAwaitingCountSettingServiceInterface
{
    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    /**
     * @var ParticipantAwaitingCountSettingRepositoryInterface
     */
    private ParticipantAwaitingCountSettingRepositoryInterface $participantAwaitingCountSettingRepository;

    /**
     * @var int
     */
    private int $status;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var array
     */
    private array $data = [];

    private array $settings = [
        AwaitingCountType::AwaitingYoung => 0,
        AwaitingCountType::AwaitingMiddle => 0,
        AwaitingCountType::AwaitingOld => 0,
        AwaitingCountType::ApprovedBefore24hYoung => 0,
        AwaitingCountType::ApprovedBefore24hMiddle => 0,
        AwaitingCountType::ApprovedBefore24hOld => 0,
        AwaitingCountType::ApprovedAfter24hYoung => 0,
        AwaitingCountType::ApprovedAfter24hMiddle => 0,
        AwaitingCountType::ApprovedAfter24hOld => 0
    ];

    /**
     * ParticipantAwaitingCountSettingService constructor.
     * @param ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
     * @param ParticipantAwaitingCountSettingRepositoryInterface $participantAwaitingCountSettingRepository
     */
    public function __construct(
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        ParticipantAwaitingCountSettingRepositoryInterface $participantAwaitingCountSettingRepository
    )
    {
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->participantAwaitingCountSettingRepository = $participantAwaitingCountSettingRepository;
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * @param int $prefectureId
     * @param int $datingDayId
     * @return ParticipantAwaitingCountSettingServiceInterface
     */
    public function countParticipants(int $prefectureId, int $datingDayId): ParticipantAwaitingCountSettingServiceInterface
    {
        $this->data = [
            'count' => $this->participantMainMatchRepository->getCountPerGenderByPrefectureAndDatingDay(
                $prefectureId, 
                $datingDayId, 
                [ParticipantsStatus::Awaiting]
            )->transform(function ($item) {
                return [
                    'gender' => $item['gender'],
                    'count' => $item['count']
                ];
            })->toArray()
        ];
        return $this;
    }

    /**
     * Format response data
     *
     * @return array
     */
    public function handleApiResponse(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }

    /**
     * @param Collection $collection
     * @param string $type
     * @return float
     */
    private function getSettingByTypeFromCollection(Collection $collection, string $type): float
    {
        $filterByTypeCollection = $collection->filter(function (ParticipantAwaitingCountSetting $model) use ($type) {
            return $model->getType() === $type;
        });
        return $filterByTypeCollection->count() ? $filterByTypeCollection->first()->getCount() : 0;
    }

    /**
     * @param int $prefectureId
     * @param int $datingDayId
     * @param int $gender
     * @return ParticipantAwaitingCountSettingServiceInterface
     */
    public function getSettings(int $prefectureId, int $datingDayId, int $gender): ParticipantAwaitingCountSettingServiceInterface
    {
        $settingsCollection = $this->participantAwaitingCountSettingRepository->getSettings($gender, $datingDayId, $prefectureId);
        foreach ($this->settings as $type => $value)
        {
            $this->settings[$type] = $this->getSettingByTypeFromCollection($settingsCollection, $type);
        }
        $this->data = [
            'settings' => [
                'prefecture_id' => $prefectureId,
                'dating_day_id' => $datingDayId,
                'gender' => $gender,
                'settings' => $this->settings
            ]
        ];
        return $this;
    }

    /**
     * @param int $prefectureId
     * @param int $datingDayId
     * @param int $gender
     * @param array $settings
     * @return ParticipantAwaitingCountSettingServiceInterface
     */
    public function updateSettings(int $prefectureId, int $datingDayId, int $gender, array $settings): ParticipantAwaitingCountSettingServiceInterface
    {
        $collections = new Collection();
        foreach ($settings as $type => $value){
            $collections->add(new ParticipantAwaitingCountSetting($datingDayId, $gender, $prefectureId, $type, $value));
        }
        $this->data = [
            'result' => $this->participantAwaitingCountSettingRepository->saveSettings($collections)
        ];
        return $this;
    }
}
