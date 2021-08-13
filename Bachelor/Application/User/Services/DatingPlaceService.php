<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Enums\DatingPlaceCategory;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlace;
use Bachelor\Domain\MasterDataManagement\TrainStation\Interfaces\TrainStationRepositoryInterface;
use Bachelor\Utility\Helpers\Utility;

class DatingPlaceService
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

    public function __construct(
        DatingRepositoryInterface $datingRepository,
        DatingPlaceRepositoryInterface $datingPlaceRepository,
        TrainStationRepositoryInterface $trainStationRepository
    )
    {
        $this->datingRepository = $datingRepository;
        $this->datingPlaceRepository =$datingPlaceRepository;
        $this->trainStationRepository = $trainStationRepository;
    }

    /**
     * @param int $datingId
     * @return array
     */
    public function getThreeCafesAtSameStation(int $datingId): array
    {
        $dating = $this->datingRepository->getDatingById($datingId);

        if (! $dating) {
            return [];
        }

        $datingPlace = $this->datingPlaceRepository->getSpecificDatingPlace($dating->getDatingPlaceId());
        $trainStation = $this->trainStationRepository->findById($datingPlace->getTrainStationId());
        $datingPlaces = $this->datingPlaceRepository->getThreeDatingPlaceByTrainStationId($trainStation->getId(), DatingPlaceCategory::Cafe, [$dating->getDatingPlaceId()]);
        $stationName = $trainStation->getDefaultTrainStationTranslation()->getName();
        $results = [];
        /** @var DatingPlace $datingPlaceItem */
        foreach ($datingPlaces as $datingPlaceItem) {
            $results[] = [
                'name' => $datingPlaceItem->getDatingPlaceTranslation()->getName(),
                'id' => Utility::encode($datingPlaceItem->getId()),
                'display_phone' => $datingPlaceItem->getDisplayPhone(),
                'cafe_link' => $datingPlaceItem->getReferencePageLink(),
                'phone' => $datingPlaceItem->getPhone(),
                'station_name' => $stationName
            ];
        }

        return [
            'cafeData' => $results,
            'text1' => trans('api_messages.did_you_use_cafe', [
                'cafe' => $datingPlace->getDatingPlaceTranslation()->getName()
            ]),
            'text2' => trans('api_messages.also_next_cafe_near'),
            'text3' => $datingPlace->getDatingPlaceTranslation()->getName() . ' ' . trans('api_messages.ask_current_cafe')
        ];
    }
}
