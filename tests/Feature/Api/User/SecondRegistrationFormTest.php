<?php


namespace Api\User;


use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\MasterDataManagement\School\ModelDao\School;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreference\ModelDao\UserPreference;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class SecondRegistrationFormTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected School $school;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Female have finished 1st registration from
     */
    private function given_approved_female_logged_in_user()
    {
        $mobileNumber = '0976609768';
        $authId = Utility::encode($mobileNumber);
        $prefecture = Prefecture::factory()->create([
            'name' => 'Tokyo',
            'country_id' => 1,
            'status' => 10,
            'admin_id' => 1,
        ]);

        $this->user = User::factory()->create([
            'mobile_number' => $mobileNumber,
            'gender' => UserGender::Female,
            'status' => UserStatus::ApprovedUser,
            'registration_steps' => RegistrationSteps::StepSix,
            'team_member_rate' => 3,
            'prefecture_id' => $prefecture->id,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);

        UserProfile::factory()->create([
            'user_id' => $this->user->id,
            'school_id' => '1',
            'birthday' => '1940-05-19',
            'company_name' => 'Xvolve',
            'hobby' => 'Fashion',
        ]);

        UserPreference::factory()->create([
            'user_id' => $this->user->id,
            'first_priority' => 1,
            'second_priority' => 1,
            'third_priority' => 1
        ]);

        $userAuth = UserAuth::factory()->create([
            'user_id' => $this->user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);

        Passport::actingAs($userAuth);
    }

    /**
     * Male have finished 1st registration from
     */
    private function given_approved_male_logged_in_user()
    {
        $mobileNumber = '0976609768';
        $authId = Utility::encode($mobileNumber);
        $prefecture = Prefecture::factory()->create([
            'name' => 'Name',
            'country_id' => 1,
            'status' => 10,
            'admin_id' => 1,
        ]);

        $this->user = User::factory()->create([
            'mobile_number' => $mobileNumber,
            'gender' => UserGender::Male,
            'status' => UserStatus::ApprovedUser,
            'registration_steps' => RegistrationSteps::StepSix,
            'team_member_rate' => 3,
            'prefecture_id' => $prefecture->id,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);

        UserProfile::factory()->create([
            'user_id' => $this->user->id,
            'school_id' => '1',
            'birthday' => '1940-05-19',
            'company_name' => 'Xvolve',
            'hobby' => 'Fashion',
        ]);

        UserPreference::factory()->create([
            'user_id' => $this->user->id,
            'first_priority' => 1,
            'second_priority' => 1,
            'third_priority' => 1
        ]);

        $userAuth = UserAuth::factory()->create([
            'user_id' => $this->user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);

        Passport::actingAs($userAuth);
    }

    /**
     * Approved Female user
     * In 5th page of 2nd registration from
     * Fill all options
     * Test case: A36,A44
     */
    public function test_post_data_female_2nd_registration_form_step_five()
    {
        $this->given_approved_female_logged_in_user();
        $request = [
            'alcohol' => '3',
            'divorce' => '1',
            'marriage' => '1'
        ];

        $response = $this->json('POST', '/api/v2/user/registration/12/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful'
        ]);

        // check database
        $this->assertDatabaseHas('user_profile', [
            'drinking' => '3',
            'divorce' => '1',
            'marriage_intention' => '1'
        ]);
    }

    /**
     * Approved Female user
     * In 5th page of 2nd registration from
     * Not select drinking
     * Test case: A37
     */
    public function test_no_select_alcohol_post_data_2nd_registration_form_step_five()
    {
        $this->given_approved_male_logged_in_user();
        $request = [
            'drinking' => '',
            'divorce' => '1',
            'marriage_intention' => '1',
        ];

        $response = $this->json('POST', '/api/v2/user/registration/12/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'alcohol' => [
                    '0' => 'The alcohol field is required.'
                ]
            ]
        ]);
    }

    /**
     * Approved Male user
     * In 6th page of 2nd registration from
     * Fill all options
     * Test case: A40,A41
     */
    public function test_post_data_2nd_registration_form_step_six()
    {
        $this->given_approved_male_logged_in_user();
        $request = [
            'divorce' => '3',
            'willingnessForMarriage' => '1'
        ];

        $response = $this->json('POST', '/api/v2/user/registration/13/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful'
        ]);

        // check database
        $this->assertDatabaseHas('user_profile', [
            'divorce' => '3',
            'marriage_intention' => '1'
        ]);
    }


    /**
     * Approved Female user
     * In 6th page of 2nd registration from
     * Not select divorce
     * Test case: A42
     */
    public function test_no_select_divorce_post_data_2nd_registration_form_step_six()
    {
        $this->given_approved_male_logged_in_user();
        $request = [
            'willingnessForMarriage' => '1'
        ];

        $response = $this->json('POST', '/api/v2/user/registration/13/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'divorce' => [
                    '0' => 'The divorce field is required.'
                ]
            ]
        ]);
    }

    /**
     * Approved Male user
     * In 6th page of 2nd registration from
     * Not select marriage
     * Test case: A43
     */
    public function test_no_select_marriage_post_data_2nd_registration_form_step_six()
    {
        $this->given_approved_male_logged_in_user();
        $request = [
            'divorce' => '3',
        ];

        $response = $this->json('POST', '/api/v2/user/registration/13/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'willingnessForMarriage' => [
                    '0' => 'The willingness for marriage field is required.'
                ]
            ]
        ]);
    }

    /**
     * Approved Female user
     * Complete 5th page of 2nd registration from
     * Test case: A45-A51, A53, A55
     */
    public function test_get_data_2nd_registration_form_step_six()
    {
        $this->given_approved_female_logged_in_user();
        $response = $this->json('GET', '/api/v2/user/registration/14');
        $userResult = $response['data']['user'];

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful'
        ]);
        $this->assertEquals($userResult['gender'], UserGender::Female);
    }

    /**
     * Approved Female user
     * In 6th page of 2nd registration from
     * Fill all options
     * Test case: A52
     */
    public function test_post_data_female_2nd_registration_form_step_seven()
    {
        $this->given_approved_female_logged_in_user();
        $request = [
            'importantPreferences' => [1, 2, 3],
            'importanceOfLookValue' => 1
        ];

        $response = $this->json('POST', '/api/v2/user/registration/14/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful'
        ]);

        // check database
        $this->assertDatabaseHas('user_preference', [
            'first_priority' => '1',
            'second_priority' => '2',
            'third_priority' => '3',
            'appearance_priority' => 1
        ]);
    }

    /**
     * Approved Male user
     * In 6th page of 2nd registration from
     * Fill all options
     * Test case: A56
     */
    public function test_post_data_male_2nd_registration_form_step_seven()
    {
        $this->given_approved_male_logged_in_user();
        $request = [
            'importantPreferences' => [1, 2, 3],
            'importanceOfLookValue' => 1
        ];

        $response = $this->json('POST', '/api/v2/user/registration/14/store', $request);
        var_dump($response);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful'
        ]);

        // check database
        $this->assertDatabaseHas('user_preference', [
            'first_priority' => '1',
            'second_priority' => '2',
            'third_priority' => '3',
            'appearance_priority' => 1
        ]);
    }

    /**
     * Approved Female user
     * In 7th page of 2nd registration from
     * Test case: A57->A61, A67
     */
    public function test_get_data_male_2nd_registration_form_step_six()
    {
        $this->given_approved_male_logged_in_user();
        $response = $this->json('GET', '/api/v2/user/registration/14');
        $userResult = $response['data']['user'];

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful'
        ]);
        $this->assertEquals($userResult['gender'], UserGender::Male);
    }

    /**
     * Approved Male user
     * In 6th page of 2nd registration from
     * not select appearance importance
     * Test case: A62
     */
    public function test_no_select_appearance_importance_male_2nd_registration_form_step_seven()
    {
        $this->given_approved_male_logged_in_user();
        $request = [
            'importantPreferences' => [1, 2, 3]
        ];

        $response = $this->json('POST', '/api/v2/user/registration/14/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'importanceOfLookValue' => [
                    '0' => 'The importance of look value field is required.'
                ]
            ]
        ]);
    }

    /**
     * Approved Female user
     * In 6th page of 2nd registration from
     * not select 3 priorities
     * Test case: A63
     */
    public function test_no_select_priorities_male_2nd_registration_form_step_seven()
    {
        $this->given_approved_male_logged_in_user();
        $request = [
            'importanceOfLookValue' => 1
        ];

        $response = $this->json('POST', '/api/v2/user/registration/14/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'importantPreferences' => [
                    '0' => 'The important preferences field is required.'
                ]
            ]
        ]);
    }

    /**
     * Approved Male user
     * In 6th page of 2nd registration from
     * Fill all options
     * Test case: A64
     */
    public function test_post_data_2nd_registration_form_step_seven()
    {
        $this->given_approved_male_logged_in_user();
        $request = [
            'importantPreferences' => [4, 5, 6],
            'importanceOfLookValue' => 1
        ];

        $response = $this->json('POST', '/api/v2/user/registration/14/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful'
        ]);

        // check database
        $this->assertDatabaseHas('user_preference', [
            'first_priority' => '4',
            'second_priority' => '5',
            'third_priority' => '6',
            'appearance_priority' => 1
        ]);
    }


}
