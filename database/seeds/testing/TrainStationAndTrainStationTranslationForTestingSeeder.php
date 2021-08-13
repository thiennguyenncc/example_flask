<?php

namespace Database\Seeders;

use Bachelor\Domain\MasterDataManagement\TrainStation\Interfaces\TrainStationRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainStationAndTrainStationTranslationForTestingSeeder extends Seeder
{
    protected TrainStationRepositoryInterface $trainStationRepository;

    public function __construct(TrainStationRepositoryInterface $trainStationRepository)
    {
        $this->trainStationRepository = $trainStationRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trainStations = [
            [
                'google_train_station_id' => '3e76c0bdcf8bfb01b99f9ec3dd914074e16e3e37',
                'lang' => [
                    [
                        'language_id' => 1,
                        'name' => 'Shintomichō Sta.',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'language_id' => 2,
                        'name' => '新富町駅',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                ]
            ],
            [
                'google_train_station_id' => '3e76c0bdcf8bfb01b99f9ec3dd914074e16e3e37',
                'lang' => [
                    [
                        'language_id' => 1,
                        'name' => 'Ginza-itchōme Station',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'language_id' => 2,
                        'name' => '銀座一丁目駅',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                ]
            ],
            [
                'google_train_station_id' => '9c16178fe27d3a690c6365e198f671173b7d08a0',
                'lang' => [
                    [
                        'language_id' => 1,
                        'name' => 'Yoyogi-Koen Station',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'language_id' => 2,
                        'name' => '代々木公園駅',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                ]
            ],
            [
                'google_train_station_id' => '6d7d48d0bfbeb86eb408d737d1239d0c52fd4c6d',
                'lang' => [
                    [
                        'language_id' => 1,
                        'name' => 'Roppongi Station',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'language_id' => 2,
                        'name' => '六本木駅',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                ]
            ],
            [
                'google_train_station_id' => '3e76c0bdcf8bfb01b99f9ec3dd914074e16e3e37',
                'lang' => [
                    [
                        'language_id' => 1,
                        'name' => 'Shibuya Station',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'language_id' => 2,
                        'name' => '渋谷駅',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                ]
            ],
            [
                'google_train_station_id' => 'a7dfc8c2dec03c48c7fe912a1f45d6bfa8420f89',
                'lang' => [
                    [
                        'language_id' => 1,
                        'name' => 'Shibuya Station',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ],
                    [
                        'language_id' => 2,
                        'name' => '渋谷駅',
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]
                ]
            ]

        ];
        DB::beginTransaction();
        try {
            foreach ($trainStations as $trainStationData) {
                $trainStation = $this->trainStationRepository->create([
                    'google_train_station_id' => $trainStationData['google_train_station_id'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
//                $trainStation = DB::table('train_stations')->create([
//                    'google_train_station_id' => $trainStationData['google_train_station_id'],
//                    'created_at' => Carbon::now(),
//                    'updated_at' => Carbon::now()
//                ]);
                $trainStation->trainStationTranslations()
                    ->createMany($trainStationData['lang']);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}
