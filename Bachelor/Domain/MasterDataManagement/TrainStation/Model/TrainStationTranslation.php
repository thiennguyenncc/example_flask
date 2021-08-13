<?php

namespace Bachelor\Domain\MasterDataManagement\TrainStation\Model;

use Bachelor\Domain\Base\BaseDomainModel;

class TrainStationTranslation extends BaseDomainModel
{
    /**
     * @var int
     */
    protected int $trainStationId;

    /**
     * @var int
     */
    protected int $languageId;

    /**
     * @var string
     */
    protected string $name;

    /**
     * TrainStationTranslation constructor.
     * @param int $trainStationId
     * @param int $languageId
     * @param string $name
     */
    public function __construct(int $trainStationId, int $languageId, string $name)
    {
        $this->trainStationId = $trainStationId;
        $this->languageId = $languageId;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getTrainStationId(): int
    {
        return $this->trainStationId;
    }

    /**
     * @param int $trainStationId
     */
    public function setTrainStationId(int $trainStationId): void
    {
        $this->trainStationId = $trainStationId;
    }

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    /**
     * @param int $languageId
     */
    public function setLanguageId(int $languageId): void
    {
        $this->languageId = $languageId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


}
