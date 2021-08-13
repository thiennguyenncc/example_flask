<?php


namespace Tests\Feature\Api\Participation\GetDatingDays;


use Tests\Feature\Api\Participation\BaseParticipantTest;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Enums\ParticipationOpenExpireStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;

use Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\ModelDao\UserTrial;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;

use Bachelor\Utility\Helpers\Utility;
use Database\Seeders\CouponSeeder;
use Database\Seeders\ParticipantAwaitingCancelSettingForTestingSeeder;
use Database\Seeders\ParticipantAwaitingCountSettingForTestingSeeder;
use Database\Seeders\ParticipationOpenExpirySettingForTestingExistingUserSeeder;
use Illuminate\Support\Carbon;

use Illuminate\Testing\TestResponse;
use Laravel\Passport\Passport;

use Tests\Feature\Api\Participation\BaseParticipantTest;

class ReactivateTrialMaleUserTest extends BaseParticipantTest
{
    /**
     * P_16
     * As a reactivated trial male user
     * I can participate only 1 opened date from this week to next next week
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CouponSeeder::class);
        $this->seed(ParticipationOpenExpirySettingForTestingExistingUserSeeder::class);
        $this->seed(ParticipantAwaitingCountSettingForTestingSeeder::class);
        $this->seed(ParticipantAwaitingCancelSettingForTestingSeeder::class);

        $this->monday = Carbon::now()->startOfWeek()->addHours(1);
        $this->given_dating_days();
        $this->given_prefecture();
        $this->given_reactivated_trial_male_logged_in_user();
    }

    private function given_reactivated_trial_male_logged_in_user()
    {
        $this->given_approved_male_user();
        $this->given_active_trial();
    }

    /**
     * P_16_01
     * GIVEN:
     * - I am a deactivated trial male user
     * - I am reactivated
     * - I have NOT had successful date after being reactivated
     * - I have NOT completed 2nd registration form
     * - I do NOT have participation"
     * WHEN:
     * - It's  Monday or Tuesday or Wednesday this week
     * - I go to participation screen"
     *
     * THEN:
     * - I can participate only one of the following days (opened date):
     * + Saturday, Sunday this week
     * + Wednesday, Saturday, Sunday next week
     * + Wednesday next next week
     * - I can't participate Wednesday this week (closed); Saturday, Sunday next next week (closed)"
     */
    private function given_a_canceled_trial_reapproved_male_logged_in_user()
    {
        $mobileNumber = '0123456';
        $authId = Utility::encode($mobileNumber);

        $prefecture = Prefecture::factory()->create([
            'name' => 'Name',
            'country_id' => 1,
            'status' => 10,
            'admin_id' => 1,
        ]);
        $user = User::factory()->create([
            'name' => 'Test User',
            'gender' => UserGender::Male,
            'mobile_number' => $mobileNumber,
            'status' => UserStatus::ApprovedUser,
            'registration_steps' => RegistrationSteps::StepZero,
            'prefecture_id' => $prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);
        $now = Carbon::now();
        UserTrial::factory()->create([
            'user_id' => $user->id,
            'status' => TrialStatus::TempCancelled,
            'trial_start' => $now->copy()->addWeeks(-1),
            'trial_end' => $now->copy()->addWeeks(3)
        ]);
        $userAuth = UserAuth::factory()->create([
            'user_id' => $user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);
        Passport::actingAs($userAuth);
    }

    public function test_male_opens_app_on_monday_tuesday_wednesday()
    {
        // today is Monday
        Carbon::setTestNow($this->monday->copy());
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_monday_tuesday_wednesday($response);

        // today is Tuesday
        Carbon::setTestNow($this->monday->copy()->addDay());
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_monday_tuesday_wednesday($response);

        // today is Wednesday
        Carbon::setTestNow($this->monday->copy()->addDays(2));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_monday_tuesday_wednesday($response);
    }

    private function then_expect_result_on_monday_tuesday_wednesday(TestResponse $response)
    {
        $response->assertOk();
        $weeks = $response['data']['weeks'];
        //  I can participate only one of the following day (opened date):
        //      Saturday, Sunday this week
        //      Wednesday, Saturday, Sunday next week
        //      Wednesday next next week
        //  I can't participate on Wednesday this week (expired); Saturday, Sunday next next week (closed)

        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][2]['open_expiry_status']);
    }

    /**
     * P_16_02
     * "- I can participate only one of the following days (opened date):
    + Sunday this week
    + Wednesday, Saturday, Sunday next week
    + Wednesday, Saturday next next week
    - I can't participate on Wednesday, Saturday this week (expired); Sunday next next week (closed)"
     */
    public function test_male_opens_app_on_thursday()
    {
        // today is Thursday
        Carbon::setTestNow($this->monday->copy()->addDays(3));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');

        $response->assertOk();
        $weeks = $response['data']['weeks'];

        //I can participate only one of the following day (opened date):
        //Sunday this week
        //Wednesday, Saturday, Sunday next week
        //Wednesday, Saturday next next week
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][1]['open_expiry_status']);

        //Wednesday, Saturday this week will NOT show (expired)
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][1]['open_expiry_status']);

        //I can NOT participate on Sunday next next week (closed)
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][2]['open_expiry_status']);
    }

    /**
     * P_16_03
     * "- I can participate only one of the following days (opened date):
    + Wednesday, Saturday, Sunday next week
    + Wednesday, Saturday, Sunday next next week
    - I can't participate Wednesday, Saturday, Sunday this week (expired)"
     */
    public function test_male_opens_app_on_friday_saturday_sunday()
    {
        // today is Friday
        Carbon::setTestNow($this->monday->copy()->addDays(4));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_friday_saturday_sunday($response);

        // today is Saturday
        Carbon::setTestNow($this->monday->copy()->addDays(5));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_friday_saturday_sunday($response);

        // today is Sunday
        Carbon::setTestNow($this->monday->copy()->addDays(6));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_friday_saturday_sunday($response);
    }

    private function then_expect_result_friday_saturday_sunday(TestResponse $response)
    {
        $response->assertOk();
        $weeks = $response['data']['weeks'];

        //- Wednesday, Saturday, Sunday this week will NOT show (expired)
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][2]['open_expiry_status']);

        //- I can participate only one of the following days (opened date):
        //+ Wednesday, Saturday, Sunday next week
        //+ Wednesday, Saturday, Sunday next next week
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][0]['open_expiry_status']);
    }
}
