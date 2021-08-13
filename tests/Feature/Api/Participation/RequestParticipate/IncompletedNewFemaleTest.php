<?php


namespace Tests\Feature\Api\Participation\RequestParticipate;


use Tests\Feature\Api\Participation\BaseParticipantTest;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Utility\Helpers\Utility;
use Database\Seeders\CouponSeeder;
use Database\Seeders\ParticipantAwaitingCancelSettingForTestingSeeder;
use Database\Seeders\ParticipantAwaitingCountSettingForTestingSeeder;
use Database\Seeders\ParticipationOpenExpirySettingForTestingNewUserSeeder;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;

/**
 * Class IncompletedNewMaleGetDatingDaysTest
 * P_01_01
 * @package Api\Participation
 */
class IncompletedNewFemaleTest extends BaseParticipantTest
{

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CouponSeeder::class);
        $this->seed(ParticipationOpenExpirySettingForTestingNewUserSeeder::class);
        $this->seed(ParticipantAwaitingCountSettingForTestingSeeder::class);
        $this->seed(ParticipantAwaitingCancelSettingForTestingSeeder::class);

        $this->given_a_female_logged_in_user();
        $this->monday = Carbon::now()->startOfWeek()->addHours(1);
        $this->given_dating_days();
    }

    private function given_a_female_logged_in_user()
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
            'email' => 'test@gmail.com',
            'gender' => UserGender::Female,
            'mobile_number' => $mobileNumber,
            'status' => UserStatus::IncompleteUser,
            'registration_steps' => RegistrationSteps::StepZero,
            'prefecture_id' => $prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);
        $userAuth = UserAuth::factory()->create([
            'user_id' => $user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);
        Passport::actingAs($userAuth);
    }

    /**
     * P_02_01
     */
    public function test_female_on_monday_tuesday_wednesday()
    {
        // today is Monday
        Carbon::setTestNow($this->monday->copy());
        $this->then_i_can_participate_more_than_one_day();
    }

    private function then_i_can_participate_more_than_one_day()
    {
        $response = $this->json('POST', '/api/v2/participation/request-participate',
            [
                'dateIds' => [$this->thisSunday->id, $this->thisSaturday->id]
            ]);
        $response->assertOk();
        $response->assertJsonFragment([
            'message' => 'Successful',
            'data' => [
                "user_status" => 1,
                "trial_status_or_paid" => "Free",
                "trial_end" => "",
                "registration_completed" => false,
                "had_participation" => false
            ]
        ]);
    }

    /**
     * P_02_02
     */
    public function test_female_opens_app_on_thursday()
    {
        // today is Thursday
        Carbon::setTestNow($this->monday->copy()->addDay(3));
        $this->then_i_can_participate_more_than_one_day_next_week();
    }

    /**
     * P_01_03
     */
    public function test_female_opens_app_on_friday()
    {
        // today is Friday
        Carbon::setTestNow($this->monday->copy()->addDay(4));
        $this->then_i_can_participate_more_than_one_day_next_week();
    }

    /**
     * P_01_03
     */
    public function test_female_opens_app_on_saturday()
    {
        // today is Saturday
        Carbon::setTestNow($this->monday->copy()->addDay(5));
        $this->then_i_can_participate_more_than_one_day_next_week();
    }

    /**
     * P_01_03
     */
    public function test_female_opens_app_on_sunday()
    {
        // today is Sunday
        Carbon::setTestNow($this->monday->copy()->addDay(6));
        $this->then_i_can_participate_more_than_one_day_next_week();
    }

    private function then_i_can_participate_more_than_one_day_next_week()
    {
        $response = $this->json('POST', '/api/v2/participation/request-participate',
            [
                'dateIds' => [$this->nextSaturday->id, $this->nextSunday->id]
            ]);
        $response->assertOk();
        $response->assertJsonFragment([
            'message' => 'Successful',
            'data' => [
                "user_status" => 1,
                "trial_status_or_paid" => "Free",
                "trial_end" => "",
                "registration_completed" => false,
                "had_participation" => false
            ]
        ]);
    }
}
