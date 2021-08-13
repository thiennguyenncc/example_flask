<?php

namespace Database\Seeders;

use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Enums\ParticipantForRematchStatus;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Interfaces\ParticipantForRematchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ParticipantForMainMatchOrRematchForTestingSeeder extends Seeder
{
    const LIMIT = 50;
    protected DatingDayRepositoryInterface $datingDayRepository;

    protected UserRepositoryInterface $userRepository;

    protected ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    protected ParticipantForRematchRepositoryInterface $participantForRematchRepository;

    public function __construct(
        DatingDayRepositoryInterface $datingDayRepository,
        UserRepositoryInterface $userRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        ParticipantForRematchRepositoryInterface $participantForRematchRepository
    )
    {
        $this->datingDayRepository = $datingDayRepository;
        $this->userRepository = $userRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->participantForRematchRepository = $participantForRematchRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = $this->userRepository->getUsersByLimit(self::LIMIT);
        $datingDays = $this->datingDayRepository->getDatingDays(self::LIMIT);
        /** @var User $user */
        foreach ($users as $user) {
            /** @var DatingDay $datingDay */
            foreach ($datingDays as $datingDay) {
                $participantMainMatch = $this->participantMainMatchRepository->firstOrCreate([
                    'user_id' => $user->getId(),
                    'dating_day_id' => $datingDay->getId(),
                    'status' => ParticipantsStatus::getRandomValue(),
                    'show_sample_date' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                if ($participantMainMatch->status == ParticipantsStatus::Unmatched || $participantMainMatch->status == ParticipantsStatus::Cancelled) {
                    $this->participantForRematchRepository->firstOrCreate([
                        'user_id' => $user->getId(),
                        'dating_day_id' => $datingDay->getId(),
                        'status' => ParticipantForRematchStatus::getRandomValue(),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }
        }
    }
}
