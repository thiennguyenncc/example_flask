<?php

namespace Bachelor\Domain\MasterDataManagement\Area\Model;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\MasterDataManagement\Prefecture\Model\Prefecture;
use Bachelor\Utility\Enums\Status;
use Illuminate\Database\Eloquent\Collection;

class Area extends BaseDomainModel
{
    /*
     * @var Prefecture
     */
    private Prefecture $prefecture;

    /*
     * @var string
     */
    private string $name;

    /*
     * @var int
     */
    private int $status;

    /*
     * @var string
     */
    private ?string $image;

    private ?AreaTranslation $areaTranslation;

    /*
     * @var Collection
     */
    private ?Collection $datingPlaces;

    /**
     * Area constructor.
     * @param Prefecture $prefecture
     * @param string $name
     * @param int $status
     * @param string|null $image
     * @param Collection|null $datingPlaces
     * @param AreaTranslation|null $areaTranslation
     */
    public function __construct (
        Prefecture $prefecture,
        string $name,
        ?string $image,
        int $status = Status::Active,
        ?AreaTranslation $areaTranslation = null,
        ?Collection $datingPlaces = null
    )
    {
        $this->setPrefecture($prefecture);
        $this->setName($name);
        $this->setStatus($status);
        $this->setDatingPlace($datingPlaces);
        $this->setImage($image);
        $this->setAreaTranslation($areaTranslation);
    }

    /**
     * @return Collection
     */
    public function getDatingPlace (): Collection
    {
        return $this->datingPlaces;
    }

    /**
     * @param Collection|null $datingPlaces
     */
    public function setDatingPlace(?Collection $datingPlaces): void
    {
        $this->datingPlaces = $datingPlaces;
    }

    /**
     * @return int
     */
    public function getStatus (): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus ( int $status ): void
    {
        $this->status = $status;
    }

    /**
     * @return Prefecture
     */
    public function getPrefecture (): Prefecture
    {
        return $this->prefecture;
    }

    /**
     * @param Prefecture $prefecture
     */
    public function setPrefecture ( Prefecture $prefecture ): void
    {
        $this->prefecture = $prefecture;
    }

    /**
     * @return string
     */
    public function getName (): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName ( string $name ): void
    {
        $this->name = $name;
    }

    /**
     * @return ?string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param ?string $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return AreaTranslation|null
     */
    public function getAreaTranslation(): ?AreaTranslation
    {
        return $this->areaTranslation;
    }

    /**
     * @param AreaTranslation|null $areaTranslation
     */
    public function setAreaTranslation(?AreaTranslation $areaTranslation): void
    {
        $this->areaTranslation = $areaTranslation;
    }


}
