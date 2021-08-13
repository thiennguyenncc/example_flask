<?php

namespace Bachelor\Domain\MasterDataManagement\DatingPlace\Services;

use Bachelor\Domain\MasterDataManagement\DatingPlace\Factories\DatingPlaceFactory;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlace;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Traits\DatingPlaceDataExtractorTrait;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Traits\DatingPlaceDataFormatterTrait;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace as DatingPlaceDao;

class DatingPlaceDomainService
{
    use DatingPlaceDataExtractorTrait, DatingPlaceDataFormatterTrait;

    /*
    * @var DatingPlaceRepositoryInterface
    */
    private DatingPlaceRepositoryInterface $datingPlaceRepository;

    /**
     * @var DatingPlaceFactory
     */
    private DatingPlaceFactory $datingPlaceFactory;

    /**
     * DatingPlaceRepositoryInterface constructor.
     * @param DatingPlaceRepositoryInterface $datingPlaceRepository
     * @param DatingPlaceFactory $datingPlaceFactory
     */
    public function __construct (DatingPlaceRepositoryInterface $datingPlaceRepository, DatingPlaceFactory $datingPlaceFactory)
    {
        $this->datingPlaceRepository = $datingPlaceRepository;
        $this->datingPlaceFactory = $datingPlaceFactory;
    }
}
