<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Interfaces\ParticipantRecommendationSettingRepositoryInterface;
use Illuminate\Http\Response;

class AdminParticipantRecommendationSettingService
{
    private int $status;

    private string $message;

    private array $data = [];

    private ParticipantRecommendationSettingRepositoryInterface $participantRecommendationSettingRepository;

    public function __construct(ParticipantRecommendationSettingRepositoryInterface $participantRecommendationSettingRepository)
    {
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');

        $this->participantRecommendationSettingRepository = $participantRecommendationSettingRepository;
    }

    /**
     * Get all recommendations
     *
     * @param array $request
     * @return AdminParticipantRecommendationSettingService
     */
    public function getRecommendations(array $request): AdminParticipantRecommendationSettingService
    {
        $this->data = [];
        $datingDayId = isset($request['dating_day_id']) ? $request['dating_day_id'] : null;
        $gender = isset($request['gender']) ? $request['gender'] : null;
        $recommendations = $this->participantRecommendationSettingRepository->getCollection($datingDayId, $gender);
        foreach ($recommendations as $recommendation) {
            $this->data[$recommendation->getDatingDayId()][] = [
                'dating_day_id' => $recommendation->getDatingDayId(),
                'dating_date' => $recommendation->getDatingDay()->getDatingDate(),
                'gender' =>  $recommendation->getGender(),
                'days_before' => $recommendation->getDaysBefore(),
                'ratio' => $recommendation->getRatio()
            ];
        }
        $this->data = array_values($this->data);

        return $this;
    }

    /**
     * @param int $dateId
     * @param int $gender
     * @param array $ratios
     * @return AdminParticipantRecommendationSettingService
     * @throws \Exception
     */
    public function setRecommendations(int $dateId, int $gender, array $ratios): AdminParticipantRecommendationSettingService
    {
        $dayRatios = array_map(function ($item) {
            return ['days_before' => $item['daysBefore'], 'ratio' => $item['ratio']];
        }, $ratios);

        $this->participantRecommendationSettingRepository->bulkSet($dateId, $gender, $dayRatios);

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
