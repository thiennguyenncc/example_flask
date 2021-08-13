<?php


namespace Api\User;


use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class SecondPageOfFirstRegistrationFormTest extends TestCase
{
    use RefreshDatabase;

    private $userId;

    /**
     * As a user who is in page 2 of 1st registration form,
     * I want to fill partner's preference about appearance
     */
    private function given_a_male_user_filled_page_one_in_first_registration_form()
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
            'gender' => UserGender::Male,
            'mobile_number' => $mobileNumber,
            'email' => 'test@gmail.com',
            'status' => UserStatus::IncompleteUser,
            'registration_steps' => RegistrationSteps::StepOne,
            'prefecture_id' => $prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);
        $this->userId = $user->id;
        $userProfile = UserProfile::factory()->create([
            'user_id' => $user->id,
            'birthday' => '1999/01/01',
        ]);

        $userAuth = UserAuth::factory()->create([
            'user_id' => $user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);

        Passport::actingAs($userAuth);

    }

    /** Testcase: R_03_03
     * "- New MALE user
     * - In step 1
     * -  fill partner's preference about appearance  "
     */
    public function test_male_user_submit_partner_appearance()
    {
        $this->given_a_male_user_filled_page_one_in_first_registration_form();

        $request = [
            'facePreferences' => 'st_02,st_03,st_07,st_11,st_10,st_13,st_09,st_12,st_08,st_05,st_06,st_01,st_04',
        ];

        $response = $this->json('POST', '/api/v2/user/registration/1/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'user_id' => $this->userId,
            'face_preferences' => 'st_02,st_03,st_07,st_11,st_10,st_13,st_09,st_12,st_08,st_05,st_06,st_01,st_04',
        ]);
    }

    /** Testcase: R_03_05
     * "- New MALE user
     * - In step 1
     * - Choose less than 3 options
     *
     * expect:
     * "- Show error message *3つ以上選択して下さい
     * - Cannot go to the next page"
     */
    public function test_male_user_submit_less_than_3()
    {
        $this->given_a_male_user_filled_page_one_in_first_registration_form();

        $request = [
            'facePreferences' => 'st_02,st_03',
        ];

        $response = $this->json('POST', '/api/v2/user/registration/1/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid.',
        ]);
    }

    /**
     * As a user who is in page 2 of 1st registration form,
     * I want to fill partner's preference about appearance
     */
    private function given_a_female_user_filled_page_one_in_first_registration_form()
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
            'gender' => UserGender::Female,
            'mobile_number' => $mobileNumber,
            'email' => 'test@gmail.com',
            'status' => UserStatus::IncompleteUser,
            'registration_steps' => RegistrationSteps::StepZero,
            'prefecture_id' => $prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);
        $this->userId = $user->id;

        $userProfile = UserProfile::factory()->create([
            'user_id' => $user->id,
            'birthday' => '1999/01/01',
        ]);
        $userAuth = UserAuth::factory()->create([
            'user_id' => $user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);

        Passport::actingAs($userAuth);
    }

    /**
     * Test case: R_03_08
     * "- New FEMALE user
     * - In step 1
     * - fill partner's preference about appearance "
     */
    public function test_female_user_submit_partner_appearance()
    {
        $this->given_a_female_user_filled_page_one_in_first_registration_form();

        $request = [
            'facePreferences' => "st_01,st_02,st_03,st_04,st_08,st_07,st_14,st_15,st_09,st_10,st_12,st_13",
        ];

        $response = $this->json('POST', '/api/v2/user/registration/1/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'user_id' => $this->userId,
            'face_preferences' => "st_01,st_02,st_03,st_04,st_08,st_07,st_14,st_15,st_09,st_10,st_12,st_13",
        ]);
    }

    /**
     * Test case: R_03_10
     * "- New FEMALE user
     * - In step 1
     * - choose less than 3 options
     *
     * expect:
     * "- Show error message *3つ以上選択して下さい
    - Cannot go to the next page"
     */
    public function test_female_user_submit_less_than_3()
    {
        $this->given_a_female_user_filled_page_one_in_first_registration_form();

        $request = [
            'facePreferences' => "st_01,st_02",
        ];

        $response = $this->json('POST', '/api/v2/user/registration/1/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid',
        ]);
    }
}
