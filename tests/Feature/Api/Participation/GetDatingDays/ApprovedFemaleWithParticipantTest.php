<?php


namespace Tests\Feature\Api\Participation\GetDatingDays;


use Tests\Feature\Api\Participation\BaseParticipantTest;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Enums\ParticipationOpenExpireStatus;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao\Feedback;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
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

/**
 * Class ApprovedFemaleWithParticipantTest
 * P_08_01
 * @package Api\Participation
 */
class ApprovedFemaleWithParticipantTest extends BaseParticipantTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CouponSeeder::class);
        $this->seed(ParticipationOpenExpirySettingForTestingExistingUserSeeder::class);
        $this->seed(ParticipantAwaitingCountSettingForTestingSeeder::class);
        $this->seed(ParticipantAwaitingCancelSettingForTestingSeeder::class);

        $this->given_female_logged_in_user();

        $this->monday = Carbon::now()->startOfWeek()->addHours(1);
        $this->given_dating_days();
        $this->given_participant_and_dating();
        $this->given_feedback();
    }

    private function given_participant_and_dating()
    {
        ParticipantMainMatch::factory()->create([
            'user_id' => $this->user->id,
            'dating_day_id' => $this->thisWednesday->id,
            'status' => ParticipantsStatus::Matched
        ]);
        $datingPlace = DatingPlace::factory()->create([
            'area_id' => 1,
            'train_station_id' => 1,
            'category' => 'category',
            'latitude' => 1,
            'longitude' => 1,
            'rating' => 1,
            'display_phone' => '123',
            'phone' => '123',
            'reference_page_link' => 'http://link.com',
            'status' => 1,
            'image' => 'image'
        ]);
        $this->dating = Dating::factory()->create([
            'dating_day_id' => $this->lastWednesday->id,
            'dating_place_id' => $datingPlace->id,
            'status' => DatingStatus::Completed
        ]);
        DatingUser::factory()->create([
            'dating_id' => $this->dating->id,
            'user_id' => $this->user->id
        ]);
    }

    private function given_female_logged_in_user()
    {
        $mobileNumber = '0123456';
        $authId = Utility::encode($mobileNumber);

        $prefecture = Prefecture::factory()->create([
            'name' => 'Name',
            'country_id' => 1,
            'status' => 10,
            'admin_id' => 1,
        ]);
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'gender' => UserGender::Female,
            'mobile_number' => $mobileNumber,
            'status' => UserStatus::ApprovedUser,
            'registration_steps' => RegistrationSteps::StepFinal,
            'prefecture_id' => $prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);
        $userAuth = UserAuth::factory()->create([
            'user_id' => $this->user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);
        Passport::actingAs($userAuth);
    }

    public function test_female_opens_app_on_monday()
    {
        // today is Monday
        Carbon::setTestNow($this->monday->copy());
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_monday($response);
    }

    public function test_female_opens_app_on_tuesday()
    {
        // today is Tuesday
        Carbon::setTestNow($this->monday->copy()->addDay(1));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_tuesday_wednesday_thursday($response);
    }

    public function test_female_opens_app_on_wednesday()
    {
        // today is Wednesday
        Carbon::setTestNow($this->monday->copy()->addDay(2));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_tuesday_wednesday_thursday($response);
    }

    public function test_female_opens_app_on_thursday()
    {
        // today is Thursday
        Carbon::setTestNow($this->monday->copy()->addDay(3));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_tuesday_wednesday_thursday($response);
    }

    private function then_expect_result_on_monday(TestResponse $response)
    {
        $response->assertOk();
        $weeks = $response['data']['weeks'];

        //"- I can participate multiple dates of the following days (opened date):
        //+ Wednesday, Saturday, Sunday this week
        //+ Wednesday, Saturday, Sunday next week"
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][2]['open_expiry_status']);
    }

    private function then_expect_result_on_tuesday_wednesday_thursday(TestResponse $response)
    {
        $response->assertOk();
        $weeks = $response['data']['weeks'];

        //"- I can participate multiple dates of the following days (opened date):
        //+ Saturday, Sunday this week
        //+ Wednesday, Saturday, Sunday next week
        //+ Wednesday next next week
        //- I can't participate Wednesday this week (expired); Saturday, Sunday next next week (closed)"
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

    public function test_female_opens_app_on_friday()
    {
        // today is Friday
        Carbon::setTestNow($this->monday->copy()->addDay(4));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_friday($response);
    }

    public function test_female_opens_app_on_saturday()
    {
        // today is Saturday
        Carbon::setTestNow($this->monday->copy()->addDay(5));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_saturday_sunday($response);
    }


    public function test_female_opens_app_on_sunday()
    {
        // today is Sunday
        Carbon::setTestNow($this->monday->copy()->addDay(6));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_saturday_sunday($response);
    }

    private function then_expect_result_friday(TestResponse $response)
    {
        $response->assertOk();
        $weeks = $response['data']['weeks'];

        //"- I can participate multiple dates of the following days (opened date):
        //+ Sunday this week
        //+ Wednesday, Saturday, Sunday next week
        //+ Wednesday, Saturday next next week
        //- I can't participate Wednesday, Saturday this week (expired); Sunday next next week (closed)"
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][2]['open_expiry_status']);
    }

    private function then_expect_result_saturday_sunday(TestResponse $response)
    {
        $response->assertOk();
        $weeks = $response['data']['weeks'];

        //"- I can participate multiple dates of the following days (opened date):
        //+ Wednesday, Saturday, Sunday next week
        //+ Wednesday, Saturday, Sunday next next week"
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[2][2]['open_expiry_status']);
    }
}
