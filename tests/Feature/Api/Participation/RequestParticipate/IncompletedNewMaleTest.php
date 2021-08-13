<?php


namespace Tests\Feature\Api\Participation\RequestParticipate;


use Tests\Feature\Api\Participation\BaseParticipantTest;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;
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
class IncompletedNewMaleTest extends BaseParticipantTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CouponSeeder::class);
        $this->seed(ParticipationOpenExpirySettingForTestingNewUserSeeder::class);
        $this->seed(ParticipantAwaitingCountSettingForTestingSeeder::class);
        $this->seed(ParticipantAwaitingCancelSettingForTestingSeeder::class);

        $this->given_a_male_logged_in_user();
        $this->monday = Carbon::now()->startOfWeek()->addHours(1);
        $this->given_dating_days();
    }

    private function given_a_male_logged_in_user()
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
            'gender' => UserGender::Male,
            'mobile_number' => $mobileNumber,
            'status' => UserStatus::IncompleteUser,
            'registration_steps' => RegistrationSteps::StepZero,
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

    /**
     * P_01_01
     * P_01_04
     */
    public function test_male_on_monday()
    {
        // today is Monday
        Carbon::setTestNow($this->monday->copy());
        $this->then_i_can_participate_one_day();
        $this->then_i_can_not_participate_more_than_one_day();
    }

    private function then_i_can_participate_one_day()
    {
        $response = $this->json('POST', '/api/v2/participation/request-participate',
            [
                'dateIds' => [$this->thisSunday->id]
            ]);
        $response->assertOk();
    }

    private function then_i_can_not_participate_more_than_one_day()
    {
        $response = $this->json('POST', '/api/v2/participation/request-participate',
            [
                'dateIds' => [$this->thisSunday->id, $this->thisSaturday->id]
            ]);
        $response->assertStatus(500);
        $response->assertJsonFragment([
           'message' => 'You do not have permission to participate!'
        ]);
    }

    /**
     * P_01_02
     */
    public function test_male_opens_app_on_thursday()
    {
        // today is Thursday
        Carbon::setTestNow($this->monday->copy()->addDay(3));
        $this->then_i_can_participate_one_day();
        $this->then_i_can_not_participate_more_than_one_day();
    }

    /**
     * P_01_03
     */
    public function test_male_opens_app_on_friday_saturday_sunday()
    {
        // today is Friday
        Carbon::setTestNow($this->monday->copy()->addDay(4));
        $this->then_i_can_participate_one_day();
        $this->then_i_can_not_participate_more_than_one_day();

        // today is Saturday
        Carbon::setTestNow($this->monday->copy()->addDay(5));
        $this->then_i_can_participate_one_day();
        $this->then_i_can_not_participate_more_than_one_day();

        // today is Sunday
        Carbon::setTestNow($this->monday->copy()->addDay(6));
        $this->then_i_can_participate_one_day();
        $this->then_i_can_not_participate_more_than_one_day();
    }

    /**
     * P_01_04
     */
    public function test_male_has_participant()
    {
        $this->given_participant();
        $this->then_i_can_not_participate_another_day();
    }

    private function given_participant()
    {
        ParticipantMainMatch::factory()->create([
            'user_id' => $this->user->id,
            'dating_day_id' => $this->thisWednesday->id,
            'status' => ParticipantsStatus::Awaiting
        ]);
        $this->then_i_can_not_participate_another_day();
    }

    private function then_i_can_not_participate_another_day()
    {
        $response = $this->json('POST', '/api/v2/participation/request-participate',
            [
                'dateIds' => [$this->thisSaturday->id]
            ]);
        $response->assertStatus(500);
        $response->assertJsonFragment([
            'message' => 'You do not have permission to participate!'
        ]);
    }
}
