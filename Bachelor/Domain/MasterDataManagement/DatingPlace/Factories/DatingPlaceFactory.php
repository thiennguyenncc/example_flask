<?php

namespace Bachelor\Domain\MasterDataManagement\DatingPlace\Factories;

use Bachelor\Domain\Base\Language\Enums\Languages;
use Bachelor\Domain\DatingManagement\DatingDay\Enums\DatingDayOfWeek;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlace;
use Bachelor\Domain\MasterDataManagement\Area\Model\Area;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceOpenCloseSetting;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceTranslation;
use Bachelor\Domain\MasterDataManagement\TrainStation\Model\TrainStation;
use Bachelor\Utility\Enums\Status;

class DatingPlaceFactory
{
    /**
     * @param Area $area
     * @param array $params
     * @return DatingPlace
     */
    public function createDatingPlace(Area $area, array $params): DatingPlace
    {
        $datingPlaceTranslations = collect();

        foreach (Languages::getValues() as $shortCode) {
            $datingPlaceTranslations->push(
                new DatingPlaceTranslation(
                    NULL,
                    Languages::fromValue($shortCode)->toLangId(),
                    $params['name' . ucfirst($shortCode)],
                    $params['displayAddress'],
                    $params['zipCode']
                )
            );
        }

        $datingPlaceOpenClosedSettings = collect();

        foreach (DatingDayOfWeek::getValues() as $dayOfWeek) {
            $datingPlaceOpenClosedSettings->push(
                new DatingPlaceOpenCloseSetting(
                    NULL,
                    $dayOfWeek,
                    $params[$dayOfWeek]['open_at'],
                    $params[$dayOfWeek]['close_at']
                )
            );
        }

        return new DatingPlace(
            $area->getId(),
            $params['category'],
            $params['latitude'],
            $params['longitude'],
            $params['rating'],
            $params['displayPhone'],
            $params['phone'],
            $params['status'] ?? Status::Active,
            $params['trainStationId'],
            $params['referencePageLink'],
            $params['datingPlaceImage'],
            $datingPlaceTranslations,
            $datingPlaceOpenClosedSettings
        );
    }
}
