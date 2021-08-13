<?php


namespace Api\User;


use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class FirstPageOfFirstRegistrationFormTest extends TestCase
{
    use RefreshDatabase;

    protected $prefectureId;

    /**
     * As a user who is in 1st page of 1st registration form,
     * I want to fill gender, birthday, area, mail, invitation code
     *
     * "- New male/ female user
     * - In step 0 of 1st registration form "
     */
    private function given_a_logged_in_user_at_step_zero()
    {
        $mobileNumber = '0123456';
        $authId = Utility::encode($mobileNumber);
        $prefecture = Prefecture::factory()->create([
            'name' => 'Name',
            'country_id' => 1,
            'status' => 10,
            'admin_id' => 1,
        ]);

        $this->prefectureId = $prefecture->id;

        $user = User::factory()->create([
            'mobile_number' => $mobileNumber,
            'status' => UserStatus::IncompleteUser,
            'registration_steps' => RegistrationSteps::StepZero,
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
     * Test case: R_02_01
     * "- New male/ female user
     * - In step 0
     * - Fill all required fields (gender, birthday, prefecture, mail, code) "
     */
    public function test_submit_basic_info_data()
    {
        $this->given_a_logged_in_user_at_step_zero();

        $request = [
            'email' => 'test@gmail.com',
            'code' => 'promotion code',
            'gender' => UserGender::Male,
            'date' => 1,
            'month' => 1,
            'year' => 1999,
            'prefectureId' => $this->prefectureId,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/0/store', $request);
        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful'
        ]);

        // check database
        $this->assertDatabaseHas('users', [
            'registration_steps' => RegistrationSteps::StepZero,
            'gender' => UserGender::Male,
            'prefecture_id' => $this->prefectureId,
            'email' => 'test@gmail.com',
        ]);
        $this->assertDatabaseHas('user_profile', [
            'birthday' => '1999-01-01 00:00:00',
        ]);

        $this->assertDatabaseHas('user_invitation', [
            'promotion_code' => 'promotion code',
        ]);
    }

    /**
     * Test case: R_02_05
     * "- New male/ female user
     * - In step 0
     *
     * - Not fill birthday & submit
     *
     * expect:
     * "- Show error message *必須 (required)
    - Cannot go to the next page"
     */
    public function test_submit_not_fill_birthday()
    {
        $this->given_a_logged_in_user_at_step_zero();

        $request = [
            'email' => 'test@gmail.com',
            'code' => 'promotion code',
            'gender' => UserGender::Male,
            'date' => "",
            'month' => "",
            'year' => "",
            'prefectureId' => $this->prefectureId,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/0/store', $request);
        // check response
        $response->assertStatus(422);
        $response->assertSimilarJson([
            'errors' => [
              'date' => ['The date field is required.'],
                'month' => ['The month field is required.'],
                'year' => ['The year field is required.'],
            ],
            'message' => 'The given data was invalid.'
        ]);
    }

    /**
     * Test case: R_02_6
     * "- New male/ female user
     * - In step 0
     * - Not fill email & submit
     *
     * expect:
     * "- Show error message *必須 (required)
    - Cannot go to the next page"
     */
    public function test_submit_not_fill_email()
    {
        $this->given_a_logged_in_user_at_step_zero();

        $request = [
            'email' => null,
            'code' => 'promotion code',
            'gender' => UserGender::Male,
            'date' => 1,
            'month' => 1,
            'year' => 1999,
            'prefectureId' => $this->prefectureId,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/0/store', $request);
        // check response
        $response->assertStatus(422);
        $response->assertExactJson([
            'errors' => [
              'email' => ['The email field is required.']
            ],
            'message' => 'The given data was invalid.'
        ]);
    }
    /**
     * Test case: R_02_07
     * - Fill email field existed in database & submit
     */
    public function test_submit_exist_email()
    {
        $this->given_a_logged_in_user_at_step_zero();
        $this->given_another_user_with_same_email();
        $request = [
            'email' => 'test@gmail.com',
            'code' => 'promotion code',
            'gender' => UserGender::Male,
            'date' => 1,
            'month' => 1,
            'year' => 1999,
            'prefectureId' => $this->prefectureId,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/0/store', $request);

        $response->dump();

        // check response
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.'
        ]);
    }

    /**
     * Test case: R_02_08
     * - Fill email field existed in database & submit
     */
    public function test_submit_invalid_email()
    {
        $this->given_a_logged_in_user_at_step_zero();
        $request = [
            'email' => 'testgmail.com',
            'code' => 'code',
            'gender' => UserGender::Male,
            'date' => 1,
            'month' => 1,
            'year' => 1999,
            'prefectureId' => $this->prefectureId,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/0/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.'
        ]);
    }

    private function given_another_user_with_same_email()
    {
        $prefecture = Prefecture::factory()->create([
            'name' => 'Name',
            'country_id' => 1,
            'status' => 10,
            'admin_id' => 1,
        ]);
        User::factory()->create([
            'email' => 'test@gmail.com',
            'mobile_number' => '1',
            'prefecture_id' => $prefecture->id,
            'status' => UserStatus::IncompleteUser,
            'registration_steps' => RegistrationSteps::StepZero,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);
    }

}
