<?php

namespace Database\Seeders;

use Bachelor\Domain\Base\Language\Enums\Languages;
use Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\ModelDao\TrainStation;
use Faker\Generator;
use Illuminate\Database\Seeder;

class TrainStationSeeder extends Seeder
{
    private Generator $faker;

    /**
     * AreaSeeder constructor.
     * @param Generator $faker
     *
     */
    public function __construct(
        Generator $faker
    ) {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trainStations = $this->getInstances();

        foreach ($trainStations as $trainStation) {

            $trainStationModel = TrainStation::create([
                'google_train_station_id' => $trainStation['google_train_station_id']
            ]);
            foreach (Languages::getValues() as $key => $value) {
                $trainStationModel->trainStationTranslations()->create([
                    'train_station_id' => $trainStationModel->getKey(),
                    'name' => $trainStation['name'] . ' ' . $value,
                    'language_id' => $key + 1,
                ]);
            }
        }
    }

    public function getInstances()
    {
        $stations = [];
        for ($i = 0; $i < 30; $i++) {
            $stations[] = [
                "google_train_station_id" => \Str::random(20),
                "name" => $this->faker->streetName . " station",
            ];
        }
        return $stations;
    }
}
