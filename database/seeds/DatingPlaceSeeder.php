<?php

namespace Database\Seeders;

use Bachelor\Domain\Base\Language\Enums\Languages;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Enums\DatingPlaceCategory;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao\Area;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;
use Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\ModelDao\TrainStation;
use Faker\Generator;
use Illuminate\Database\Seeder;

class DatingPlaceSeeder extends Seeder
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
        $datingPlaces = $this->getInstances();

        foreach ($datingPlaces as $datingPlace) {

            $datingPlaceModel = DatingPlace::create([
                "area_id" => $datingPlace['area_id'],
                "train_station_id" => $datingPlace['train_station_id'],
                "category" => $datingPlace['category'],
                "latitude" => $datingPlace['latitude'],
                "longitude" => $datingPlace['longitude'],
                "rating" => $datingPlace['rating'],
                "display_phone" => $datingPlace['display_phone'],
                "phone" => $datingPlace['phone'],
                "reference_page_link" => $datingPlace['reference_page_link'],
                "status" => $datingPlace['status'],
                "image" => $datingPlace['image'],
            ]);
            foreach (Languages::getValues() as $key => $value) {
                $datingPlaceModel->datingPlaceTranslations()->create([
                    'dating_place_id' => $datingPlaceModel->getKey(),
                    'language_id' => $key + 1,
                    'name' => $datingPlace['name'] . ' ' . $value,
                    'display_address' => $datingPlace['display_address'] . ' ' . $value,
                    'zip_code' => $datingPlace['zip_code'],
                ]);
            }
        }
    }

    public function getInstances()
    {
        $instances = [];
        for ($i = 0; $i < 30; $i++) {
            $instances[] = [
                "area_id" => Area::inRandomOrder()->first()->id,
                "train_station_id" => TrainStation::inRandomOrder()->first()->id,
                "category" => DatingPlaceCategory::getRandomValue(),
                "latitude" => $this->faker->numberBetween(0, 90 * 2 * 100000) * 0.00001 - 90,
                "longitude" => $this->faker->numberBetween(0, 180 * 2 * 100000) * 0.00001 - 180,
                "rating" => $this->faker->numberBetween(0, 10) / 2,
                "display_phone" => $this->faker->phoneNumber,
                "phone" => $this->faker->phoneNumber,
                "reference_page_link" => $this->faker->url,
                "status" => $this->faker->numberBetween(0, 1),
                "image" => $this->faker->imageUrl(),
                "name" => $this->faker->streetName . " Cafe",
                "display_address" => $this->faker->address,
                "zip_code" => $this->faker->randomNumber(3) . '-' . $this->faker->randomNumber(4),
            ];
        }
        return $instances;
    }
}
