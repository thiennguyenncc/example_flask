<?php

namespace Bachelor\Domain\MasterDataManagement\DatingPlace\Traits;

use Bachelor\Domain\Base\Language\Enums\Languages;
use function GuzzleHttp\json_decode;

trait DatingPlaceDataExtractorTrait
{
    /**
     * Get base prefecture data
     *
     * @param array $param
     * @return array
     */
    protected function getBaseDatingPlaceData(array $param): array
    {
        // Retrieve the prefecture data
        return $this->datingPlaceRepository->buildIndexQuery($param)
            ->simplePaginate(
                $this->datingPlaceRepository->getModel()
                    ->getPerPage()
            )->toArray();
    }

    /**
     * Get the train station for the dating place via google map's places api
     *
     * @param array $param
     * @return array
     * @throws \Exception
     */
    protected function getTrainStationsForTheDatingPlace(array $param): array
    {
        $numberOfTrainStationsRequired = config('constants.number_of_train_stations');

        for ($index = 0; $index < $numberOfTrainStationsRequired; $index++) {
            $param['trainStations'][$index]['trainStation'] = self::obtainNearestTrainStations($param, $index);

            if (count(Languages::getKeys()) != count($param['trainStations'][$index]['trainStation']))
                throw new \Exception(__('api_messages.datingPlace.unable_to_find_train_station'), [
                    'datingPlaceName' => $param['nameEn'],
                    'language' => $index + 1
                ]);
        }

        return $param;
    }

    /**
     * Obtain nearest train stations
     *
     * @param array $param
     * @param int $index
     * @return array
     */
    protected function obtainNearestTrainStations(array $param, int $index): array
    {
        $trainStation = [];

        foreach (Languages::getInstances() as $key => $language) {
            $trainStation[$key] =  self::obtainNearestTrainStation(
                $param['latitude'],
                $param['longitude'],
                $language->value
            )[$index];
        }

        return $trainStation;
    }

    /**
     * Used for get the details of the train station based on the latitude and longitude provided
     *
     * @param double $latitude
     * @param double $longitude
     * @param int    $languageId, id of language
     *
     * @return array $trainDataArray, that contains the train station data
     */
    public function obtainNearestTrainStation($latitude, $longitude, $languageId)
    {
        return json_decode(
            file_get_contents(
                'https://maps.googleapis.com/maps/api/place/nearbysearch/json?
                key=' . config('services.google_places_api.google_api_key') .
                    '&location=' . $latitude . ', ' . $longitude . '
                &rankby=distance
                &type=subway_station
                &language=' . $languageId
            ),
            true
        )['results'];
    }
}
