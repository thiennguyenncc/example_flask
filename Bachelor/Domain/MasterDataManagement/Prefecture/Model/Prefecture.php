<?php

namespace Bachelor\Domain\MasterDataManagement\Prefecture\Model;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Utility\Enums\Status;
use Illuminate\Support\Collection;

class Prefecture extends BaseDomainModel
{
    /*
     * @var int
     */
    private int $countryId;

    /*
     * @var int
     */
    private int $status;

    /*
     * @var int
     */
    private int $adminId;

    /*
     * @var string
     */
    private string $name;

    /*
     * @var string
     */
    private PrefectureTranslation $prefectureTranslation;

    /**
     * Prefecture constructor.
     *
     * @param string $name
     * @param int $countryId
     * @param int $status
     * @param int $adminId
     */
    public function __construct (string $name, int $countryId,int $adminId, int $status = Status::Active)
    {
        $this->setCountryId($countryId);
        $this->setStatus($status);
        $this->setAdminId($adminId);
        $this->setName($name);
    }

    /**
     * @return int
     */
    public function getCountryId (): int
    {
        return $this->countryId;
    }

    /**
     * @param int $countryId
     */
    public function setCountryId ( int $countryId ): void
    {
        $this->countryId = $countryId;
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
     * @return int
     */
    public function getAdminId (): int
    {
        return $this->adminId;
    }

    /**
     * @param int $adminId
     */
    public function setAdminId ( int $adminId ): void
    {
        $this->adminId = $adminId;
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
     * @return PrefectureTranslation
     */
    public function getPrefectureTranslation(): PrefectureTranslation
    {
        return $this->prefectureTranslation;
    }

    /**
     * @param PrefectureTranslation $prefectureTranslation
     */
    public function setPrefectureTranslation(PrefectureTranslation $prefectureTranslation): void
    {
        $this->prefectureTranslation = $prefectureTranslation;
    }
}
