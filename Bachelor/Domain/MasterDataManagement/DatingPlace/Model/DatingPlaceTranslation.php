<?php

namespace Bachelor\Domain\MasterDataManagement\DatingPlace\Model;

use Bachelor\Domain\Base\BaseDomainModel;

class DatingPlaceTranslation extends BaseDomainModel
{
    protected ?int $datingPlaceId;

    protected int $languageId;

    protected string $name;

    protected string $displayAddress;

    protected string $zipCode;

    /**
     * DatingPlaceTranslation constructor.
     * @param int $datingPlaceId
     * @param int $languageId
     * @param string $name
     * @param string $displayAddress
     * @param string $zipCode
     */
    public function __construct(
        ?int $datingPlaceId,
        int $languageId,
        string $name,
        string $displayAddress,
        string $zipCode
    ) {
        $this->datingPlaceId = $datingPlaceId;
        $this->languageId = $languageId;
        $this->name = $name;
        $this->displayAddress = $displayAddress;
        $this->zipCode = $zipCode;
    }

    /**
     * @return int
     */
    public function getDatingPlaceId(): int
    {
        return $this->datingPlaceId;
    }

    /**
     * @param int $datingPlaceId
     */
    public function setDatingPlaceId(int $datingPlaceId): void
    {
        $this->datingPlaceId = $datingPlaceId;
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

    /**
     * @return string
     */
    public function getDisplayAddress(): string
    {
        return $this->displayAddress;
    }

    /**
     * @param string $displayAddress
     */
    public function setDisplayAddress(string $displayAddress): void
    {
        $this->displayAddress = $displayAddress;
    }

    /**
     * @return string
     */
    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    /**
     * @param string $zipCode
     */
    public function setZipCode(string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }
}
