<?php

namespace Database\Seeders;

use Bachelor\Domain\MasterDataManagement\ReviewPoint\Enums\ReviewPointStatus;
use Bachelor\Domain\MasterDataManagement\ReviewPoint\Interfaces\ReviewPointRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReviewPointForTestingSeeder extends Seeder
{
    protected ReviewPointRepositoryInterface $reviewPointRepository;

    public function __construct(ReviewPointRepositoryInterface $reviewPointRepository)
    {
        $this->reviewPointRepository = $reviewPointRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reviewPoints = [
            [
                'label' => '容姿/雰囲気',
                'key' => 'face_appearance',
                'status' => ReviewPointStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '性格・会話',
                'key' => 'personality_communication',
                'status' => ReviewPointStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'label' => '振る舞い',
                'key' => 'behavior_manner',
                'status' => ReviewPointStatus::Active,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($reviewPoints as $reviewPoint) {
            $this->reviewPointRepository->create($reviewPoint);
        }
    }
}
