<?php

namespace Database\Seeders;

use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Utility\Helpers\CollectionHelper;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatingAndDatingUserForTestingSeeder extends Seeder
{
    const LIMIT = 50;
    protected DatingDayRepositoryInterface $datingDayRepository;

    protected UserRepositoryInterface $userRepository;

    protected DatingRepositoryInterface $datingRepository;

    protected DatingPlaceRepositoryInterface $datingPlaceRepository;

    public function __construct(
        DatingDayRepositoryInterface $datingDayRepository,
        UserRepositoryInterface $userRepository,
        DatingRepositoryInterface $datingRepository,
        DatingPlaceRepositoryInterface $datingPlaceRepository
    )
    {
        $this->datingDayRepository = $datingDayRepository;
        $this->userRepository = $userRepository;
        $this->datingRepository = $datingRepository;
        $this->datingPlaceRepository = $datingPlaceRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = $this->userRepository->getRandomUser();
        $datingDays = $this->datingDayRepository->getDatingDays(self::LIMIT);
        $datingPlaces = $this->datingPlaceRepository->getDatingPlaces();
        $datingPlaceIds = CollectionHelper::convEntitiesToPropertyArray($datingPlaces, 'id');
        $userData = [
            'name' => 'Martin Lo',
            'email' => 'martinlo@gmail.com',
            'mobile_number' => '09566777888',
            'status' => UserStatus::ApprovedUser,
            'b_rate' => 4,
            'registration_steps' => 6,
            'prefecture_id' => 1,
            'team_member_rate' => 3,
            'flex_point' => 4,
            'is_fake' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        if ($user->getGender() == UserGender::Male) {
            $userData['gender'] = UserGender::Female;
        } else {
            $userData['gender'] = UserGender::Male;
        }
        $newUser = $this->userRepository->create($userData);
        /** @var DatingDay $datingDay */
        foreach ($datingDays as $datingDay) {
            $dating = $this->datingRepository->create([
                'dating_day_id' => $datingDay->getId(),
                'start_at' => '09:00:00',
                'dating_place_id' => $datingPlaceIds[array_rand($datingPlaceIds)],
                'status' => DatingStatus::getRandomValue(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $dating->datingUsers()->createMany([
                [
                    'user_id' => $user->getId(),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'user_id' => $newUser->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]);
        }
    }
}
