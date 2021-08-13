<?php


namespace Bachelor\Application\Admin\Services;


use Bachelor\Domain\MasterDataManagement\TrainStation\Interfaces\TrainStationRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\TrainStation\Model\TrainStation;
use Illuminate\Http\Response;

class AdminTrainStationService
{
    /**
     * @var TrainStationRepositoryInterface
     */
    private $trainStationRepository;

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
     * AdminSchoolService constructor.
     * @param TrainStationRepositoryInterface $trainStationRepository
     */
    public function __construct(TrainStationRepositoryInterface $trainStationRepository)
    {
        $this->trainStationRepository = $trainStationRepository;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get All Schools
     *
     * @return self
     */
    public function getTrainStation($params): self
    {
        $this->data = [
            'train_stations' => $this->trainStationRepository->getAllTrainStations()->transform(function (TrainStation $trainStation) {
                return [
                    'id' => $trainStation->getId(),
                    'google_train_station_id' => $trainStation->getGoogleTrainStationId(),
                    'station_name' => $trainStation->getDefaultTrainStationTranslation()->getName(),
                ];
            })->toArray()
        ];
        return $this;
    }

    /**
     * Format Registration data
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
}
