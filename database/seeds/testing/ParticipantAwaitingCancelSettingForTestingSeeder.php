<?php

namespace Database\Seeders;

use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Interfaces\ParticipantAwaitingCancelSettingRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ParticipantAwaitingCancelSettingForTestingSeeder extends Seeder
{
    const LIMIT = 50;
    protected DatingDayRepositoryInterface $datingDayRepository;
    protected ParticipantAwaitingCancelSettingRepositoryInterface $participantAwaitingCancelSettingRepository;

    public function __construct(
        DatingDayRepositoryInterface $datingDayRepository,
        ParticipantAwaitingCancelSettingRepositoryInterface $participantAwaitingCancelSettingRepository
    )
    {
        $this->datingDayRepository =$datingDayRepository;
        $this->participantAwaitingCancelSettingRepository = $participantAwaitingCancelSettingRepository;
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
            $this->participantAwaitingCancelSettingRepository->firstOrCreate([
                'dating_day_id' => $datingDay->getId(),
                'gender' => UserGender::getRandomValue(),
                'days_before' => rand(1,20),
                'ratio' => rand(1,100),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
