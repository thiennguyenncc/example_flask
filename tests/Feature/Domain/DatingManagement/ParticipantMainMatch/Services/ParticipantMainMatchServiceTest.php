<?php

namespace Tests\Feature\Domain\DatingManagement\ParticipantMainMatch\Services;

use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Enums\AwaitingCountType;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchService;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\ModelDao\ParticipantAwaitingCountSetting;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\ModelDao\UserInfoUpdatedTime;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipantMainMatchServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_female_male_ratio()
    {
        $datingDay = DatingDay::factory()->create([
            'dating_day' => 'Wednesday',
            'dating_date' => '1993-05-19',
        ]);

        $maleCompletedRegistrationUser = User::factory()->create([
            'name' => 'a',
            'gender' => UserGender::Male,
            'mobile_number' => mt_rand(1000000000, 9999999999),
            'status' => UserStatus::ApprovedUser,
            'registration_steps' => RegistrationSteps::StepFifteenth,
            'prefecture_id' => 1,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);

        $femaleAwaitingOldUser = User::factory()->create([
            'name' => 'b',
            'gender' => UserGender::Female,
            'mobile_number' => mt_rand(1000000000, 9999999999),
            'status' => UserStatus::AwaitingUser,
            'registration_steps' => RegistrationSteps::StepEight,
            'prefecture_id' => 1,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);

        $femaleYoungApprovedUser = User::factory()->create([
            'name' => 'b',
            'gender' => UserGender::Female,
            'mobile_number' => mt_rand(1000000000, 9999999999),
            'status' => UserStatus::ApprovedUser,
            'registration_steps' => RegistrationSteps::StepEleven,
            'prefecture_id' => 1,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);

        ParticipantMainMatch::factory()->create([
            'user_id' => $maleCompletedRegistrationUser->id,
            'dating_day_id' => $datingDay->id,
            'status' => '10',
            'show_sample_date' => '1',
        ]);

        ParticipantMainMatch::factory()->create([
            'user_id' => $femaleAwaitingOldUser,
            'dating_day_id' => $datingDay->id,
            'status' => '10',
            'show_sample_date' => '1',
        ]);

        ParticipantMainMatch::factory()->create([
            'user_id' => $femaleYoungApprovedUser->id,
            'dating_day_id' => $datingDay->id,
            'status' => '10',
            'show_sample_date' => '1',
        ]);

         UserProfile::factory()->create([
            'user_id' => $maleCompletedRegistrationUser->id,
            'school_id' => '1',
            'birthday' => '1940-05-19',
            'hobby' => 'aaa',
            'company_name' => 'bbb'
        ]);

        UserProfile::factory()->create([
            'user_id' => $femaleAwaitingOldUser->id,
            'school_id' => '1',
            'birthday' => '1940-05-19',
            'hobby' => 'aaa',
            'company_name' => 'bbb'
        ]);

        UserProfile::factory()->create([
            'user_id' => $femaleYoungApprovedUser->id,
            'school_id' => '1',
            'birthday' => '2000-05-19',
            'hobby' => 'aaa',
            'company_name' => 'bbb'
        ]);

        UserInfoUpdatedTime::factory()->create([
            'user_id' => $maleCompletedRegistrationUser->id,
            'approved_at' => '1994-05-19',
        ]);

        UserInfoUpdatedTime::factory()->create([
            'user_id' => $femaleAwaitingOldUser->id,
            'approved_at' => '1994-05-19',
        ]);

        UserInfoUpdatedTime::factory()->create([
            'user_id' => $femaleYoungApprovedUser->id,
            'approved_at' => '1994-05-19',
        ]);

        ParticipantAwaitingCountSetting::factory()->create(
            [
                'prefecture_id' => 1,
                'dating_day_id' => $datingDay->id,
                'count' => 0.5,
                'type' => AwaitingCountType::ApprovedBefore24hYoung,
                'gender' => UserGender::Female
            ]
        );

        ParticipantAwaitingCountSetting::factory()->create(
            [
                'prefecture_id' => 1,
                'dating_day_id' => $datingDay->id,
                'count' => 0.8,
                'type' => AwaitingCountType::AwaitingOld,
                'gender' => UserGender::Female
            ]
        );

        /** @var ParticipantMainMatchService $service */
        $service = $this->app->make(ParticipantMainMatchService::class);
        $result = $service->getFemaleMaleRatio(1, $datingDay->toDomainEntity());
        // 1*1 vs 1*0.8 + 1*0.5
        $this->assertEquals(130, $result);
    }
}
