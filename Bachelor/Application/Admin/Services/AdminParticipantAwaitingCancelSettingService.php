<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Interfaces\ParticipantAwaitingCancelSettingRepositoryInterface;
use Illuminate\Http\Response;

class AdminParticipantAwaitingCancelSettingService
{
    private int $status;

    private string $message;

    private array $data = [];

    private ParticipantAwaitingCancelSettingRepositoryInterface $participantAwaitingCancelSettingRepository;

    public function __construct(ParticipantAwaitingCancelSettingRepositoryInterface $participantAwaitingCancelSettingRepository)
    {
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');

        $this->participantAwaitingCancelSettingRepository = $participantAwaitingCancelSettingRepository;
    }

    /**
     * @param array $request
     * @return AdminParticipantAwaitingCancelSettingService
     */
    public function getAwaitingCancels(array $request): AdminParticipantAwaitingCancelSettingService
    {
        $this->data = [];
        $datingDayId = isset($request['dating_day_id']) ? $request['dating_day_id'] : null;
        $gender = isset($request['gender']) ? $request['gender'] : null;
        $awaitingCancels = $this->participantAwaitingCancelSettingRepository->getCollection($datingDayId, $gender);
        foreach ($awaitingCancels as $awaitingCancel) {
            $this->data[$awaitingCancel->getDatingDayId()][] = [
                'dating_day_id' => $awaitingCancel->getDatingDayId(),
                'dating_date' => $awaitingCancel->getDatingDay()->getDatingDate(),
                'gender' =>  $awaitingCancel->getGender(),
                'days_before' => $awaitingCancel->getDaysBefore(),
                'ratio' => $awaitingCancel->getRatio()
            ];
        }
        $this->data = array_values($this->data);

        return $this;
    }

    /**
     * @param int $dateId
     * @param int $gender
     * @param array $ratios
     * @return AdminParticipantAwaitingCancelSettingService
     * @throws \Exception
     */
    public function setAwaitingCancels(int $dateId, int $gender, array $ratios): AdminParticipantAwaitingCancelSettingService
    {
        $dayRatios = array_map(function ($item) {
            return ['days_before' => $item['daysBefore'], 'ratio' => $item['ratio']];
        }, $ratios);

        $this->participantAwaitingCancelSettingRepository->bulkSet($dateId, $gender, $dayRatios);

        return $this;
    }

    /**
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
}
