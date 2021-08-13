<?php

namespace Bachelor\Domain\MasterDataManagement\DatingPlace\Model;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\MasterDataManagement\Area\Model\Area;
use Bachelor\Domain\MasterDataManagement\TrainStation\Model\TrainStation;
use Bachelor\Utility\Enums\Status;
use Illuminate\Support\Collection;

class DatingPlace extends BaseDomainModel
{
    /**
     * @var int
     */
    private $areaId;

    /*
     * @var string
     */
    private string $category;

    /*
     * @var int
     */
    private int $status;

    /*
     * @var float
     */
    private float $latitude;

    /*
     * @var float
     */
    private float $longitude;

    /*
     * @var float
     */
    private float $rating;

    /*
     * @var string
     */
    private string $displayPhone;

    /*
     * @var string
     */
    private string $phone;

    /**
     * @var int
     */
    private int $trainStationId;

    /**
     * @var string
     */
    protected string $referencePageLink;

    /**
     * @var DatingPlaceTranslation
     */
    private DatingPlaceTranslation $datingPlaceTranslation;

    /**
     * @var Collection
     */
    private Collection $datingPlaceTranslations;

    /**
     * @var Collection
     */
    private Collection $datingPlaceOpenCloseSettings;

    /**
     * @var string
     */
    protected string $image;

    private ?TrainStation $trainStation;

    /**
     * DatingPlace constructor.
     * @param int $areaId
     * @param string $category
     * @param float $latitude
     * @param float $longitude
     * @param float $rating
     * @param string $displayPhone
     * @param string $phone
     * @param int $status
     * @param int $trainStationId
     * @param string $referencePageLink
     * @param Collection $datingPlaceTranslations
     * @param Collection $datingPlaceOpenCloseSettings
     * @param string $image
     */
    public function __construct(
        int $areaId,
        string $category,
        float $latitude,
        float $longitude,
        float $rating,
        string $displayPhone,
        string $phone,
        int $status,
        int $trainStationId,
        string $referencePageLink,
        string $image,
        Collection $datingPlaceTranslations,
        Collection $datingPlaceOpenCloseSettings,
    ) {
        $this->areaId = $areaId;
        $this->category = $category;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->rating = $rating;
        $this->displayPhone = $displayPhone;
        $this->phone = $phone;
        $this->status = $status;
        $this->trainStationId = $trainStationId;
        $this->referencePageLink = $referencePageLink;
        $this->datingPlaceTranslations = $datingPlaceTranslations;
        $this->datingPlaceOpenCloseSettings = $datingPlaceOpenCloseSettings;
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getDisplayPhone(): string
    {
        return $this->displayPhone;
    }

    /**
     * @param string $displayPhone
     */
    public function setDisplayPhone(string $displayPhone): void
    {
        $this->displayPhone = $displayPhone;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getAreaId(): int
    {
        return $this->areaId;
    }

    /**
     * @param int $areaId
     */
    public function setAreaId(int $areaId): void
    {
        $this->areaId = $areaId;
    }

    public function setDatingPlaceTranslation(DatingPlaceTranslation $datingPlaceTranslation): void
    {
        $this->datingPlaceTranslation = $datingPlaceTranslation;
    }

    public function getDatingPlaceTranslation(): DatingPlaceTranslation
    {
        return $this->datingPlaceTranslation;
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
     * @return string
     */
    public function getReferencePageLink(): string
    {
        return $this->referencePageLink;
    }

    /**
     * @param string $referencePageLink
     */
    public function setReferencePageLink(string $referencePageLink): void
    {
        $this->referencePageLink = $referencePageLink;
    }

    /**
     * @return Collection
     */
    public function getDatingPlaceTranslations(): Collection
    {
        return $this->datingPlaceTranslations;
    }

    /**
     * @param Collection $datingPlaceTranslations
     */
    public function setDatingPlaceTranslations(Collection $datingPlaceTranslations): void
    {
        $this->datingPlaceTranslations = $datingPlaceTranslations;
    }

    /**
     * @return Collection
     */
    public function getDatingPlaceOpenCloseSettings(): Collection
    {
        return $this->datingPlaceOpenCloseSettings;
    }

    /**
     * @param Collection $datingPlaceOpenCloseSettings
     */
    public function setDatingPlaceOpenCloseSettings(Collection $datingPlaceOpenCloseSettings): void
    {
        $this->datingPlaceOpenCloseSettings = $datingPlaceOpenCloseSettings;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $referencePageLink
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return TrainStation|null
     */
    public function getTrainStation(): ?TrainStation
    {
        return $this->trainStation;
    }

    /**
     * @param TrainStation|null $trainStation
     */
    public function setTrainStation(?TrainStation $trainStation): void
    {
        $this->trainStation = $trainStation;
    }

    /**
     * @return boolean
     */
    public function isDeleted(): bool
    {
        return $this->status === Status::Deleted;
    }

    /**
     * @return boolean
     */
    public function isApproved(): bool
    {
        return $this->status === Status::Active;
    }

    /**
     * @return boolean
     */
    public function isDisapproved(): bool
    {
        return $this->status === Status::Inactive;
    }

    /**
     * @return void
     */
    public function changeApprove()
    {
        if ($this->isApproved()) {
            return $this->setStatus(Status::Inactive);
        }
        if ($this->isDisapproved()) {
            return $this->setStatus(Status::Active);
        }
    }
}
