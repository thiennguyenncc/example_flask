<?php

namespace Database\Seeders;

use Bachelor\Domain\MasterDataManagement\StarCategory\Enums\StarCategoryStatus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StarCategoryForTestingSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $starCategories = [
            [
                'label' => '顔立ち',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '肌',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '女性らしさ',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '髪/ファッション',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '優しさ',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '明るさ',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '聡明さ',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '安心感',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => 'マナー',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '会話',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '男性らしさ',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => 'スタイル',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '紳士的',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '清潔感',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '印象',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '話し方',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '会話内容',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '振る舞い',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '身だしなみ',
                'status' => StarCategoryStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        foreach ($starCategories as $starCategory) {
            \DB::table('star_categories')->insert($starCategory);
        }
    }
}
