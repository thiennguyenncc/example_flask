<?php


namespace Database\Seeders;


use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Interfaces\ParticipationOpenExpirySettingRepositoryInterface;
use Illuminate\Database\Seeder;

class ParticipationOpenExpirySettingForTestingExistingUserSeeder extends Seeder
{
    protected ParticipationOpenExpirySettingRepositoryInterface $participationOpenExpirySettingRepository;

    public function __construct(
        ParticipationOpenExpirySettingRepositoryInterface $participationOpenExpirySettingRepository
    )
    {
        $this->participationOpenExpirySettingRepository = $participationOpenExpirySettingRepository;
    }

    private function getData()
    {
        return [
            //wednesday
            [
                'dating_day_of_week' => 'wednesday',
                'is_user_2nd_form_completed' => 1,
                'user_gender' => 1,
                'open_days_before_dating_date' => 16,
                'expiry_days_before_dating_date' => 1
            ],
            [
                'dating_day_of_week' => 'wednesday',
                'is_user_2nd_form_completed' => 0,
                'user_gender' => 1,
                'open_days_before_dating_date' => 16,
                'expiry_days_before_dating_date' => 2
            ],
            [
                'dating_day_of_week' => 'wednesday',
                'is_user_2nd_form_completed' => 1,
                'user_gender' => 2,
                'open_days_before_dating_date' => 15,
                'expiry_days_before_dating_date' => 1
            ],
            [
                'dating_day_of_week' => 'wednesday',
                'is_user_2nd_form_completed' => 0,
                'user_gender' => 2,
                'open_days_before_dating_date' => 16,
                'expiry_days_before_dating_date' => 2
            ],
            //saturday
            [
                'dating_day_of_week' => 'saturday',
                'is_user_2nd_form_completed' => 1,
                'user_gender' => 1,
                'open_days_before_dating_date' => 16,
                'expiry_days_before_dating_date' => 1
            ],
            [
                'dating_day_of_week' => 'saturday',
                'is_user_2nd_form_completed' => 0,
                'user_gender' => 1,
                'open_days_before_dating_date' => 16,
                'expiry_days_before_dating_date' => 2
            ],
            [
                'dating_day_of_week' => 'saturday',
                'is_user_2nd_form_completed' => 1,
                'user_gender' => 2,
                'open_days_before_dating_date' => 15,
                'expiry_days_before_dating_date' => 1
            ],
            [
                'dating_day_of_week' => 'saturday',
                'is_user_2nd_form_completed' => 0,
                'user_gender' => 2,
                'open_days_before_dating_date' => 16,
                'expiry_days_before_dating_date' => 2
            ],
            //sunday
            [
                'dating_day_of_week' => 'sunday',
                'is_user_2nd_form_completed' => 1,
                'user_gender' => 1,
                'open_days_before_dating_date' => 16,
                'expiry_days_before_dating_date' => 1
            ],
            [
                'dating_day_of_week' => 'sunday',
                'is_user_2nd_form_completed' => 0,
                'user_gender' => 1,
                'open_days_before_dating_date' => 16,
                'expiry_days_before_dating_date' => 2
            ],
            [
                'dating_day_of_week' => 'sunday',
                'is_user_2nd_form_completed' => 1,
                'user_gender' => 2,
                'open_days_before_dating_date' => 15,
                'expiry_days_before_dating_date' => 1
            ],
            [
                'dating_day_of_week' => 'sunday',
                'is_user_2nd_form_completed' => 0,
                'user_gender' => 2,
                'open_days_before_dating_date' => 16,
                'expiry_days_before_dating_date' => 2
            ],
        ];
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->getData();
        foreach ($data as $row)
        {
            $this->participationOpenExpirySettingRepository->firstOrCreate($row);
        }
    }
}
