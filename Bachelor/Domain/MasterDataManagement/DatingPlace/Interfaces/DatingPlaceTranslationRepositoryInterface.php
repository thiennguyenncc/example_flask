<?php


namespace Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces;

use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceTranslation;

interface DatingPlaceTranslationRepositoryInterface
{
    /**
     * Create new dating place translation
     *
     * @param DatingPlaceTranslation $datingPlaceTranslation
     * @return DatingPlaceTranslation
     */
    public function save ( DatingPlaceTranslation $datingPlaceTranslation ): DatingPlaceTranslation;
}
