<?php

namespace Bachelor\Domain\MasterDataManagement\DatingPlace\Traits;

use Bachelor\Domain\Base\Language\Enums\Languages;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait DatingPlaceDataFormatterTrait
{
    /**
     *  Format data for creating new prefecture
     *
     * @param array $params
     * @return array
     */
    protected function formatDataForDatingPlace(array $params): array
    {
        return array_merge(self::obtainFormattedDatingPlaceData($params), self::formatDataForTrainStation($params['trainStations']));
    }

    /**
     * Obtain data for dating place
     *
     * @param array $params
     * @return array
     */
    protected function obtainFormattedDatingPlaceData(array $params): array
    {
        return array_merge(self::formatDatingPlaceData($params), self::formatDatingPlaceTranslationsData($params));
    }

    /**
     * Get formatted data for dating place table
     *
     * @param array $params
     * @return array
     */
    protected function formatDatingPlaceData(array $params): array
    {
        return [
            'dating place' => [
                'area_id' => $params['areaId'],
                'category' => $params['category'],
                'latitude' => $params['latitude'],
                'longitude' => $params['longitude'],
                'rating' => $params['rating'],
                'display_phone' => $params['displayPhone'],
                'phone' => $params['phone'],
                'image' => self::retrieveDatingPlaceImageNameAfterStoring($params['datingPlaceImage']),
            ]
        ];
    }


    /**
     * Format dating place translation data
     *
     * @param array $params
     * @return array
     */
    protected function formatDatingPlaceTranslationsData(array $params): array
    {
        $datingPlaceTranslationData = [
            'datingPlaceTranslations' => []
        ];

        // fetch common data for all language type
        $baseDatingPlaceTranslationData = self::baseFormattedDatingPlaceTranslationData($params);

        foreach (Languages::getInstances() as $language) {
            $datingPlaceTranslationData['datingPlaceTranslations'][] = [
                'display_address' => $params['displayAddress'],
                'zip_code' => $params['zipCode'],
                'country' => $params['country'],
                'name' => $params['name' . Str::ucfirst($language)],
                'language_id' => Languages::$language()->toInt()
            ];
        }

        return $datingPlaceTranslationData;
    }

    /**
     * Common data for dating place translations
     *
     * @param array $params
     * @return array
     */
    protected function baseFormattedDatingPlaceTranslationData(array $params): array
    {
        return [

        ];
    }

    /**
     * Store image to s3 bucket
     *
     * @param UploadedFile $datingPlaceImage
     * @return string
     */
    protected function retrieveDatingPlaceImageNameAfterStoring(UploadedFile $datingPlaceImage): string
    {
        $imageName = $datingPlaceImage->getClientOriginalName();

        // Stores the pic to the s3 as set in the env
        Storage::put(config('constants.dating_place_storage_path') . $imageName, file_get_contents($datingPlaceImage));

        if (Utility::getFileLink($imageName, config('constants.dating_place_storage_path')))
            return $datingPlaceImage;

        return '';
    }

    /**
     * Format data for train station
     *
     * @param array $trainStations
     * @return array
     */
    protected function formatDataForTrainStation(array $trainStations): array
    {
        $trainStationData = [
            'trainStations' => []
        ];

        foreach ($trainStations as $index => $trainStation)
            $trainStationData = self::obtainFormattedTrainStationData($trainStationData, $trainStation['trainStation'], $index);


        return $trainStationData;
    }

    /**
     * Obtain formatted train station data
     *
     * @param array $trainStationData
     * @param array $trainStation
     * @param int $index
     * @return array
     */
    protected function obtainFormattedTrainStationData(array $trainStationData, array $trainStation, int $index): array
    {
        $trainStationData['trainStations'][$index]['trainStation'] = self::formatTrainStationData($trainStation, $index);

        $trainStationData['trainStations'][$index]['trainStationTranslations'] = self::formatTrainStationTranslationsData($trainStation);

        return $trainStationData;
    }

    /**
     * Obtain train station data
     *
     * @param array $trainStationData
     * @param int $index
     * @return array
     */
    protected function formatTrainStationData(array $trainStationData, int $index): array
    {
        $key = Languages::getKey('en');
        return [
            'google_train_station_id' => $trainStationData[$key]['place_id'] ?? $trainStationData['id'],
            'latitude' => $trainStationData[$key]['geometry']['location']['lat'],
            'longitude' => $trainStationData[$key]['geometry']['location']['lat'],
            'distance_priority' => $index
        ];
    }

    /**
     * Format train station translation data
     *
     * @param array $trainStationData
     * @return array
     */
    protected function formatTrainStationTranslationsData(array $trainStationData): array
    {
        $trainStationTranslationData = [];

        foreach (Languages::getInstances() as $key => $language) {
            $trainStationTranslationData[] = [
                'name' => $trainStationData[$key]['name'],
                'language_id' => Languages::$language()->toInt()
            ];
        }

        return $trainStationTranslationData;
    }
}
