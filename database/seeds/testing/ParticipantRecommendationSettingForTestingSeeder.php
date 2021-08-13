<?php

namespace Database\Seeders;

use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Interfaces\ParticipantRecommendationSettingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ParticipantRecommendationSettingForTestingSeeder extends Seeder
{
    const LIMIT = 50;
    protected DatingDayRepositoryInterface $datingDayRepository;
    protected ParticipantRecommendationSettingRepositoryInterface $participantRecommendationSettingRepository;

    public function __construct(
        DatingDayRepositoryInterface $datingDayRepository,
        ParticipantRecommendationSettingRepositoryInterface $participantRecommendationSettingRepository
    )
    {
        $this->datingDayRepository =$datingDayRepository;
        $this->participantRecommendationSettingRepository = $participantRecommendationSettingRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datingDays = $this->datingDayRepository->getDatingDays(self::LIMIT);
        /** @var DatingDay $datingDay */
        foreach ($datingDays as $datingDay) {
            $this->participantRecommendationSettingRepository->firstOrCreate([
                'dating_day_id' => $datingDay->getId(),
                'gender' => rand(1,2),
                'days_before' => rand(1,20),
                'ratio' => rand(1,100),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
