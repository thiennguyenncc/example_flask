<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Domain\Base\Language\Enums\Languages;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Enums\DatingDayOfWeek;
use Bachelor\Domain\MasterDataManagement\Area\Interfaces\AreaRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Factories\DatingPlaceFactory;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlace;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceOpenCloseSetting;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceTranslation;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Services\DatingPlaceDomainService;
use Bachelor\Domain\MasterDataManagement\TrainStation\Interfaces\TrainStationRepositoryInterface;
use Bachelor\Utility\Enums\Status;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AdminDatingPlaceService
{
    /**
     * @var DatingRepositoryInterface
     */
    protected $datingRepository;

    /**
     * @var DatingPlaceRepositoryInterface
     */
    protected $datingPlaceRepository;

    /**
     * @var TrainStationRepositoryInterface
     */
    protected TrainStationRepositoryInterface $trainStationRepository;

    /**
     * @var AreaRepositoryInterface
     */
    protected AreaRepositoryInterface $areaRepository;

    /**
     * @var DatingPlaceFactory
     */
    protected DatingPlaceFactory $datingPlaceFactory;

    /**
     * Response Status
     */
    protected int $status;

    /**
     * Response Message
     */
    protected string $message;

    /*
     * Response data
     * @var array
     */
    protected array $data = [];

    public function __construct(
        DatingRepositoryInterface $datingRepository,
        DatingPlaceRepositoryInterface $datingPlaceRepository,
        TrainStationRepositoryInterface $trainStationRepository,
        AreaRepositoryInterface $areaRepository,
        DatingPlaceDomainService $datingPlaceService,
        DatingPlaceFactory $datingPlaceFactory
    ) {
        $this->datingRepository = $datingRepository;
        $this->datingPlaceRepository = $datingPlaceRepository;
        $this->trainStationRepository = $trainStationRepository;
        $this->areaRepository = $areaRepository;
        $this->datingPlaceService = $datingPlaceService;
        $this->datingPlaceFactory = $datingPlaceFactory;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get the dating place data
     *
     * @param array $params
     * @return self
     */
    public function getDatingPlaceData(array $params): self
    {
        if (isset($params['page'])) unset($params['page']);

        $this->data = [
            'datingPlaces' => $this->datingPlaceRepository->getSpecifiedDatingPlaces(['filters' => $params])
                ->transform(function (DatingPlace $datingPlace) {
                    /* @var DatingPlace $datingPlace */
                    return [
                        'id' => $datingPlace->getId(),
                        'area_id' => $datingPlace->getAreaId(),
                        'area_name' => $this->areaRepository->getById($datingPlace->getAreaId())->getName(),
                        'train_station_name' => $datingPlace->getTrainStation()->getDefaultTrainStationTranslation()->getName(),
                        'category' => $datingPlace->getCategory(),
                        'latitude' => $datingPlace->getLatitude(),
                        'longitude' => $datingPlace->getLongitude(),
                        'rating' => $datingPlace->getRating(),
                        'display_phone' => $datingPlace->getDisplayPhone(),
                        'phone' => $datingPlace->getPhone(),
                        'status' => $datingPlace->getStatus(),
                        'name' => $datingPlace->getDatingPlaceTranslation()->getName()
                    ];
                })->toArray()
        ];

        return $this;
    }

    /**
     * Create a new dating place and obtain updated data
     *
     * @param array $params
     * @return self
     * @throws Exception
     */
    public function createNewDatingPlace(array $params): self
    {
        try {
            DB::beginTransaction();
            $areaDomainModel = $this->areaRepository->getSpecificArea($params['areaId']);

            $params['datingPlaceImage'] = Utility::storeFile($params['datingPlaceImage'], config('constants.cafe_storage_path'));
            $datingPlaceDomainModel = $this->datingPlaceFactory->createDatingPlace($areaDomainModel, $params);
            $this->datingPlaceRepository->save($datingPlaceDomainModel);
            $this->message = __('api_messages.datingPlace.successfully_created_new_dating_place');

            DB::commit();
            return $this;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * Update dating place data
     *
     * @param int $datingPlaceId
     * @param array $params
     * @return self
     * @throws Exception
     */
    public function updateDatingPlace(int $datingPlaceId, array $params): self
    {
        try {
            DB::beginTransaction();
            $areaDomainModel = $this->areaRepository->getById($params['areaId']);
            if (!$areaDomainModel) {
                throw new \Exception("area not found");
            }

            $datingPlaceDomainModel = $this->datingPlaceRepository->getById($datingPlaceId);
            $datingPlaceDomainModel->setAreaId($areaDomainModel->getId());
            $datingPlaceDomainModel->setCategory($params['category']);
            $datingPlaceDomainModel->setLatitude($params['latitude']);
            $datingPlaceDomainModel->setLongitude($params['longitude']);
            $datingPlaceDomainModel->setRating($params['rating']);
            $datingPlaceDomainModel->setDisplayPhone($params['displayPhone']);
            $datingPlaceDomainModel->setPhone($params['phone']);
            $datingPlaceDomainModel->setStatus($params['status']);
            $datingPlaceDomainModel->setTrainStationId($params['trainStationId']);
            $datingPlaceDomainModel->setStatus($params['referencePageLink']);
            $datingPlaceDomainModel->setStatus($params['datingPlaceImage']);
            $datingPlaceTranslations = $datingPlaceDomainModel->getDatingPlaceTranslations();
            $datingPlaceTranslations->each(function (DatingPlaceTranslation $datingPlaceTranslation) use ($params) {
                $shortCode = Languages::getShortCodeById($datingPlaceTranslation->getLanguageId());
                $datingPlaceTranslation->setName($params['name' . ucfirst($shortCode)]);
                $datingPlaceTranslation->setDisplayAddress($params['displayAddress']);
                $datingPlaceTranslation->setZipCode($params['zipCode']);
            });

            $datingPlaceOpenCloseSettings = $datingPlaceDomainModel->getDatingPlaceOpenCloseSettings();
            $datingPlaceOpenCloseSettings->each(function (DatingPlaceOpenCloseSetting $datingPlaceOpenCloseSetting) use ($params) {
                $dayOfWeek = $datingPlaceOpenCloseSetting->getDayOfWeek();
                $datingPlaceOpenCloseSetting->setOpenAt($params[$dayOfWeek]['open_at']);
                $datingPlaceOpenCloseSetting->setCloseAt($params[$dayOfWeek]['close_at']);
            });

            $this->datingPlaceRepository->save($datingPlaceDomainModel);

            $this->message = __('api_messages.datingPlace.successfully_updated_dating_place');
            DB::commit();
            return $this;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Change approve dating place
     *
     * @param int $datingPlaceId
     * @return self
     * @throws Exception
     */
    public function approveOrDisapproveDatingPlace(int $datingPlaceId): self
    {
        try {
            DB::beginTransaction();

            $datingPlaceDomainModel = $this->datingPlaceRepository->getSpecificDatingPlace($datingPlaceId);
            if (!$datingPlaceDomainModel->isDeleted()) {
                $datingPlaceDomainModel->changeApprove();
                if ($this->datingPlaceRepository->save($datingPlaceDomainModel)) {
                    $this->message = __('api_messages.datingPlace.successfully_updated_dating_place');
                    DB::commit();
                    return $this;
                }
            }
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * Delete dating place
     *
     * @param int $datingPlaceId
     * @return self
     * @throws Exception
     */
    public function analyzeAndDeleteDatingPlace(int $datingPlaceId): self
    {
        $this->updateDatingPlace($datingPlaceId, ['status' => Status::Deleted]);

        $this->message = __('api_messages.datingPlace.successfully_deleted_dating_place');

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
