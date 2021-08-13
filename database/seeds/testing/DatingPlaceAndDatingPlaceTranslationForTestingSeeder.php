<?php

namespace Database\Seeders;

use Bachelor\Domain\MasterDataManagement\DatingPlace\Enums\DatingPlaceCategory;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\TrainStation\Interfaces\TrainStationRepositoryInterface;
use Bachelor\Utility\Helpers\CollectionHelper;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatingPlaceAndDatingPlaceTranslationForTestingSeeder extends Seeder
{
    protected DatingPlaceRepositoryInterface $datingPlaceRepository;

    protected TrainStationRepositoryInterface $trainStationRepository;

    public function __construct(
        DatingPlaceRepositoryInterface $datingPlaceRepository,
        TrainStationRepositoryInterface $trainStationRepository
    )
    {
        $this->datingPlaceRepository = $datingPlaceRepository;
        $this->trainStationRepository = $trainStationRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trainStations = $this->trainStationRepository->getAllTrainStations();
        $trainStationIds = CollectionHelper::convEntitiesToPropertyArray($trainStations,'id');
        DB::beginTransaction();
        try {
            $count = 0;
            while ($count < 50) {
                $datingPlace = $this->datingPlaceRepository->create([
                    'area_id' => 1,
                    'train_station_id' => $trainStationIds[array_rand($trainStationIds)],
                    'category' => DatingPlaceCategory::getRandomValue(),
                    'latitude' => 35.6721142,
                    'longitude' => 139.7708253,
                    'rating' => rand(1,5),
                    'display_phone' => '03-3535-1817',
                    'phone' => '+81335351817',
                    'reference_page_link' => 'https://i.gyazo.com/a32cf5b125514027bb2d788ae260d011.jpg',
                    'status' => 1,
                    'image' => 'https://i.gyazo.com/a32cf5b125514027bb2d788ae260d011.jpg',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                $randomNumber = rand(1,1000);
                $datingPlace->datingPlaceTranslations()
                    ->createMany([
                        [
                            'language_id' => 1,
                            'name' => 'Cafe Ohzan Ginza Mitsukoshi' . $randomNumber,
                            'display_address' => '銀座三越 B2F,Chūō, 東京都 〒104-0061,Japan' . $randomNumber,
                            'zip_code' => '104-0061',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ],
                        [
                            'language_id' => 2,
                            'name' => 'カフェ オウザン 銀座三越店' . $randomNumber,
                            'display_address' => '〒104-0061 東京都中央区,銀座三越 B2F' . $randomNumber,
                            'zip_code' => '104-0061',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ]
                    ]);
                $count ++;
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
