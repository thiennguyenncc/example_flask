<?php

namespace Bachelor\Domain\MasterDataManagement\TrainStation\Model;

use Bachelor\Domain\Base\BaseDomainModel;
use Illuminate\Support\Collection;

class TrainStation extends BaseDomainModel
{
    /**
     * @var int
     */
    protected int $googleTrainStationId;

    /**
     * @var TrainStationTranslation
     */
    protected TrainStationTranslation $defaultTrainStationTranslation;

    /**
     * @var Collection
     */
    protected Collection $trainStationTranslations;

    /**
     * TrainStation constructor.
     * @param int $googleTrainStationId
     * @param Collection $trainStationTranslations
     */
    public function __construct(
        int $googleTrainStationId,
        Collection $trainStationTranslations
    ) {
        $this->googleTrainStationId = $googleTrainStationId;
        $this->trainStationTranslations = $trainStationTranslations;
    }

    /**
     * @return Collection
     */
    public function getTrainStationTranslations(): Collection
    {
        return $this->trainStationTranslations;
    }

    /**
     * @param Collection $trainStationTranslations
     */
    public function setTrainStationTranslations(Collection $trainStationTranslations): void
    {
        $this->trainStationTranslations = $trainStationTranslations;
    }

    /**
     * @return int
     */
    public function getGoogleTrainStationId(): int
    {
        return $this->googleTrainStationId;
    }

    /**
     * @param int $googleTrainStationId
     */
    public function setGoogleTrainStationId(int $googleTrainStationId): void
    {
        $this->googleTrainStationId = $googleTrainStationId;
    }

    /**
     * @return TrainStationTranslation
     */
    public function getDefaultTrainStationTranslation(): TrainStationTranslation
    {
        return $this->defaultTrainStationTranslation;
    }

    /**
     * @param TrainStationTranslation $defaultTrainStationTranslation
     */
    public function setDefaultTrainStationTranslation(TrainStationTranslation $defaultTrainStationTranslation): void
    {
        $this->defaultTrainStationTranslation = $defaultTrainStationTranslation;
    }
}
