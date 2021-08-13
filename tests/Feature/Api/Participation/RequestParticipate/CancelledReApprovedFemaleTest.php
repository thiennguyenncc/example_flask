<?php


namespace Tests\Feature\Api\Participation\RequestParticipate;


use Tests\Feature\Api\Participation\BaseParticipantTest;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;
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
use Laravel\Passport\Passport;

/**
 * Class CancelledReApprovedFemaleTest
 * P_05_01
 * @package Api\Participation\GetDatingDays
 */
class CancelledReApprovedFemaleTest extends BaseParticipantTest
{

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CouponSeeder::class);
        $this->seed(ParticipationOpenExpirySettingForTestingExistingUserSeeder::class);
        $this->seed(ParticipantAwaitingCountSettingForTestingSeeder::class);
        $this->seed(ParticipantAwaitingCancelSettingForTestingSeeder::class);

        $this->monday = Carbon::now()->startOfWeek()->addHours(1);

        $this->given_a_reapproved_existing_female_logged_in_user();
        $this->given_dating_days();
    }

    /**
     * "- I am an existing female user (I have card & have successful date)
     * - I cancel my account
     * - I am reapproved
     * "
    **/
    private function given_a_reapproved_existing_female_logged_in_user()
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
                "user_status" => UserStatus::ApprovedUser,
                "trial_status_or_paid" => "Free",
                "trial_end" => "",
                "registration_completed" => false,
                "had_participation" => false
            ]
        ]);
    }

    /**
     * P_05_05
     * "- I am a cancelled female user
     * - I am reapproved
     * - I had successful date after being approved
     * - I have NOT sent recent feedback
     * - I do NOT have uncollective invoice"
     */
    public function test_female_without_feedback()
    {
        $this->given_participant_and_dating();
        $this->then_i_can_not_participate_another_day();
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

    private function then_i_can_not_participate_another_day()
    {
        $response = $this->json('POST', '/api/v2/participation/request-participate',
            [
                'dateIds' => [$this->thisSaturday->id]
            ]);
        $response->assertStatus(500);
        $response->assertJsonFragment([
            'message' => 'You need to send feedback first!',
            "exception" => "Exception"
        ]);
    }

    public function test_female_with_feedback()
    {
        $this->given_participant_and_dating();
        $this->given_feedback();
        $this->then_i_can_participate_another_day();
    }

    private function then_i_can_participate_another_day()
    {
        $response = $this->json('POST', '/api/v2/participation/request-participate',
            [
                'dateIds' => [$this->thisSaturday->id]
            ]);
        $response->assertOk();
    }
}
