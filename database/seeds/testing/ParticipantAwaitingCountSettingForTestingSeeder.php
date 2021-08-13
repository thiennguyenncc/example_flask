<?php

namespace Database\Seeders;

use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Enums\AwaitingCountType;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Interfaces\ParticipantAwaitingCountSettingRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ParticipantAwaitingCountSettingForTestingSeeder extends Seeder
{
    const LIMIT = 50;
    protected DatingDayRepositoryInterface $datingDayRepository;
    protected ParticipantAwaitingCountSettingRepositoryInterface $participantAwaitingCountSettingRepository;

    public function __construct(
        DatingDayRepositoryInterface $datingDayRepository,
        ParticipantAwaitingCountSettingRepositoryInterface $participantAwaitingCountSettingRepository
    )
    {
        $this->datingDayRepository =$datingDayRepository;
        $this->participantAwaitingCountSettingRepository = $participantAwaitingCountSettingRepository;
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

            $this->participantAwaitingCountSettingRepository->firstOrCreate([
                'dating_day_id' => $datingDay->getId(),
                'gender' => rand(1,2),
                'prefecture_id' => rand(1,5),
                'type' => AwaitingCountType::getRandomValue(),
                'count' => rand(1,100),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
