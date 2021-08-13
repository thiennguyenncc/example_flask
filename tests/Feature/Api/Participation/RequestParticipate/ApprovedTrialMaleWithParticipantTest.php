<?php


namespace Tests\Feature\Api\Participation\RequestParticipate;


use Tests\Feature\Api\Participation\BaseParticipantTest;
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
use Database\Seeders\ParticipationOpenExpirySettingForTestingNewUserSeeder;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;

/**
 * Class ApprovedTrialMaleWithParticipantTest
 * P_06_01
 * @package Api\Participation
 */
class ApprovedTrialMaleWithParticipantTest extends BaseParticipantTest
{
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CouponSeeder::class);
        $this->seed(ParticipationOpenExpirySettingForTestingNewUserSeeder::class);
        $this->seed(ParticipantAwaitingCountSettingForTestingSeeder::class);
        $this->seed(ParticipantAwaitingCancelSettingForTestingSeeder::class);

        $this->given_a_trial_approved_male_logged_in_user();
        $this->monday = Carbon::now()->startOfWeek()->addHours(1);
        $this->given_dating_days();
    }

    private function given_a_trial_approved_male_logged_in_user()
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
            'status' => TrialStatus::Active,
            'trial_start' => $now->copy()->addWeeks(-1),
            'trial_end' => $now->copy()->addWeeks(3)
        ]);
        $userAuth = UserAuth::factory()->create([
            'user_id' => $user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);
        Passport::actingAs($userAuth);
        $this->user = $user;
    }

    /**
     * P_06_01
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
}
