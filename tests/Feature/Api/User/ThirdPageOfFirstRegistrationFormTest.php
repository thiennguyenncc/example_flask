<?php


namespace Api\User;


use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreference\ModelDao\UserPreference;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ThirdPageOfFirstRegistrationFormTest extends TestCase
{
    use RefreshDatabase;

    private $userId;

    /**
     * As a male user who is in page 3 of 1st registration form,
     * I want to fill partner's preference about job, age, height
     */
    private function given_a_logged_in_male_user_at_step_zero()
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
            'registration_steps' => RegistrationSteps::StepTwo,
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
     * Test case:
     * "- Keep default job, age, height preference
     * - Submit"
     *
     * +expect:
     * -> status: 200
     * -> message: "successful"
     * -> database:
     * 'job' => "",
     * 'age_from' => 0,
     * 'age_to' => 99,
     * 'height_from' => 0,
     * 'height_to' => 999,
     *
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     */
    public function test_male_user_submit_partner_default_data()
    {
        $this->given_a_logged_in_male_user_at_step_zero();

        $request = [
            'job' => "", //why default job is empty?
            'minAge' => 0,
            'maxAge' => 99,
            'minHeight' => 0,
            'maxHeight' => 999,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'job' => "",
            'age_from' => 0,
            'age_to' => 99,
            'height_from' => 0,
            'height_to' => 999,
        ]);
    }

    /**
     * Test case: R_04_03
     * "- Choose job
     * - Keep default age, height
     * - Submit"
     *
     * -> expect:
     * -> status: 200
     * -> message: "successful"
     * database:
     * 'job' => "job_06",
     *   'age_from' => 0,
     *   'age_to' => 99,
     *   'height_from' => 0,
     *  'height_to' => 999,
     */
    public function test_male_user_choose_job_default_age_height()
    {
        $this->given_a_logged_in_male_user_at_step_zero();

        $request = [
            'job' => "job_06",
            'minAge' => 0,
            'maxAge' => 99,
            'minHeight' => 0,
            'maxHeight' => 999,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'job' => "job_06",
            'age_from' => 0,
            'age_to' => 99,
            'height_from' => 0,
            'height_to' => 999,
        ]);
    }

    /**
     * Test case: R_04_04
     * "- Choose height: min <= max - 10
     * - Keep default job, age
     * - Submit"
     *
     * expect:
     * -> message: "successful"
     * -> status: 200
     * DB:
     *'job' => "",
     * 'age_from' => 0,
     * 'age_to' => 99,
     * 'height_from' => 150,
     * 'height_to' => 160,
     *
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     */
    public function test_male_user_R04_04()
    {
        $this->given_a_logged_in_male_user_at_step_zero();

        $request = [
            'job' => "",
            'minAge' => 0,
            'maxAge' => 99,
            'minHeight' => 150,
            'maxHeight' => 160,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'job' => "",
            'age_from' => 0,
            'age_to' => 99,
            'height_from' => 150,
            'height_to' => 160,
        ]);
    }

    /**
     * Test case: R_04_05
     *
     * "- Height: min = X cm, max = do not mind
     * - Keep default job, age
     * - Submit"
     *
     * expect:
     * -> message: "successful"
     * -> status: 200
     * DB:
     *'job' => "",
     * 'age_from' => 0,
     * 'age_to' => 99,
     * 'height_from' => 150,
     * 'height_to' => 999,
     *
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     */
    public function test_male_user_R04_05()
    {
        $this->given_a_logged_in_male_user_at_step_zero();

        $request = [
            'job' => "",
            'minAge' => 0,
            'maxAge' => 99,
            'minHeight' => 150,
            'maxHeight' => 999,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'job' => "",
            'age_from' => 0,
            'age_to' => 99,
            'height_from' => 150,
            'height_to' => 999,
        ]);
    }

    /**
     * Test case: R_04_06
     * "- Height: min = do not mind, max >= 160cm
     * - Keep default job, age
     * - Submit"
     *
     * expect:
     * -> message: "successful"
     * -> status: 200
     * DB:
     *'job' => "",
     * 'age_from' => 0,
     * 'age_to' => 99,
     * 'height_from' => 0,
     * 'height_to' => 160,
     *
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     */
    public function test_male_user_R04_06()
    {
        $this->given_a_logged_in_male_user_at_step_zero();

        $request = [
            'job' => "",
            'minAge' => 0,
            'maxAge' => 99,
            'minHeight' => 0,
            'maxHeight' => 160,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'job' => "",
            'age_from' => 0,
            'age_to' => 99,
            'height_from' => 0,
            'height_to' => 160,
        ]);
    }
    /**
     * Test case: R_04_07
     * "- Height: min = do not mind, max < 160cm
    - Keep default job, age
    - Submit"
     *
     * expect:
     * "- Can NOT go to the next page
    - Show error message: *希望の幅は10cm以上取ってください"
     *
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     * WHEN I PUT A JOB TO JOB FIELD, IT RETURNS 200 BUT EXPECT ERRORS
     */
    public function test_male_user_R04_07()
    {
        $this->given_a_logged_in_male_user_at_step_zero();

        $request = [
            'job' => "job_06",
            'minAge' => 0,
            'maxAge' => 99,
            'minHeight' => 0,
            'maxHeight' => 159,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid',
        ]);
    }

    /**
     * Test case: R_04_08
     * "- Choose height: min > max
    - Keep default job, age
    - Submit"
     *
     * expect:
     * "- Can NOT go to the next page
    - Show error message: *最小値は最大値以下の数値を
    入力してください"
     *
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     * WHEN I PUT A JOB TO JOB FIELD, IT RETURNS 200 BUT EXPECT ERRORS
     */
    public function test_male_user_R04_08()
    {
        $this->given_a_logged_in_male_user_at_step_zero();

        $request = [
            'job' => "job_06",
            'minAge' => 0,
            'maxAge' => 99,
            'minHeight' => 160,
            'maxHeight' => 159,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid',
        ]);
    }

    /**
     * Test case: R_04_09
     * "- Choose: age from > age to - 8
    - Keep default job, height
    - Submit"
     *
     * expect:
     * "- Can NOT go to the next page
    - Show error message: *希望の幅は8歳以上取ってください"
     *
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     * WHEN I PUT A JOB TO JOB FIELD, IT RETURNS 200 BUT EXPECT ERRORS
     */
    public function test_male_user_R04_09()
    {
        $this->given_a_logged_in_male_user_at_step_zero();

        $request = [
            'job' => "job_06",
            'minAge' => 21,
            'maxAge' => 28,
            'minHeight' => 0,
            'maxHeight' => 999,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid',
        ]);
    }

    /**
     * Test case: R_04_10
     * "- Choose age: min > max
    - Keep default job, height
    - Submit"
     *
     * expect:
     * "- Can NOT go to the next page- Show error message: *最小値は最大値以下の数値を
    入力してください"
     *
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     * WHEN I PUT A JOB TO JOB FIELD, IT RETURNS 200 BUT EXPECT ERRORS
     */
    public function test_male_user_R04_10()
    {
        $this->given_a_logged_in_male_user_at_step_zero();

        $request = [
            'job' => "job_06",
            'minAge' => 22,
            'maxAge' => 21,
            'minHeight' => 0,
            'maxHeight' => 999,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(422);
        $response->assertJsonFragment([
            'message' => 'The given data was invalid',
        ]);
    }
    /**
     * Test case: R_04_11
     * "- Choose: age from <= age to - 8
     * - Keep default job, height
     * - Submit"
     *
     * expect:
     * -> message: "successful"
     * -> status: 200
     * DB:
     *'job' => "",
     * 'age_from' => 20,
     * 'age_to' => 28,
     * 'height_from' => 0,
     * 'height_to' => 999,
     *
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     */
    public function test_male_user_R04_11()
    {
        $this->given_a_logged_in_male_user_at_step_zero();

        $request = [
            'job' => "",
            'minAge' => 20,
            'maxAge' => 28,
            'minHeight' => 0,
            'maxHeight' => 999,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'job' => "",
            'age_from' => 20,
            'age_to' => 28,
            'height_from' => 0,
            'height_to' => 999,
        ]);
    }

    /**
     * As a male aged >= 40y.o, I can choose partner' age_to >= [user's age - 5]
     * (if not choose premium plan) or = any age (if choose premium plan)
     */
    private function given_a_logged_in_male_user_40_yo()
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
            'registration_steps' => RegistrationSteps::StepTwo,
            'prefecture_id' => $prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);

        $this->userId = $user->id;

        UserProfile::factory()->create([
            'user_id' => $user->id,
            'birthday' => '1981/01/01',

        ]);

        $userAuth = UserAuth::factory()->create([
            'user_id' => $user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);

        Passport::actingAs($userAuth);
    }

    /**
     * Test case: R_05_02
     * "- Choose 'age to' >= user's age - 5
     * - Submit"
     *
     * expect:
     * -> message: "successful"
     * -> status: 200
     * DB:
     *'job' => "",
     * 'age_from' => 0,
     * 'age_to' => 38,
     * 'height_from' => 0,
     * 'height_to' => 999,
     *
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     */
    public function test_male_user_R05_02()
    {
        $this->given_a_logged_in_male_user_40_yo();

        $request = [
            'job' => "",
            'minAge' => 0,
            'maxAge' => 38,
            'minHeight' => 0,
            'maxHeight' => 999,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(200); //422
        $response->assertJsonFragment([
            'message' => 'Successful', //the given data was invalid
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'job' => "",
            'age_from' => 0,
            'age_to' => 38,
            'height_from' => 0,
            'height_to' => 999,
        ]);
    }

    /**
     * Test case: R_05_05
     * "- Choose any option for 'age to'
     * - Click button プレミアムプランで無料体験する
     *
     * expect:
     * -> message: "successful"
     * -> status: 200
     * DB:
     *'job' => "",
     * 'age_from' => 20,
     * 'age_to' => 28,
     * 'height_from' => 0,
     * 'height_to' => 999,
     *
     * 'cost_plan' => null
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     */
    public function test_male_user_R05_05()
    {
        $this->given_a_logged_in_male_user_40_yo();

        $request = [
            'job' => "",
            'minAge' => 20,
            'maxAge' => 28,
            'minHeight' => 0,
            'maxHeight' => 999,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'job' => "",
            'age_from' => 20,
            'age_to' => 28,
            'height_from' => 0,
            'height_to' => 999,
        ]);
        $this->assertDatabaseMissing('user_plan', [
            'user_id' => $this->userId,
            'plan_id' => 1,
        ]);
    }

    /**
     * Test case: R_05_11
     * "- Re-select 'age to' < user's age - 5
    - Click button プレミアムプランで無料体験する in popup https://gyazo.com/6f83842bc56a895d11d0961a52b3b5d1"
     *- Click submit button
     *
     * expect:
     * -> message: "successful"
     * -> status: 200
     * DB:
     *'job' => "",
     * 'age_from' => 20,
     * 'age_to' => 28,
     * 'height_from' => 0,
     * 'height_to' => 999,
     *
     * 'cost_plan' => null
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     */
    public function test_male_user_R05_11()
    {
        $this->given_a_logged_in_male_user_40_yo();

        $request = [
            'job' => "",
            'minAge' => 20,
            'maxAge' => 28,
            'minHeight' => 0,
            'maxHeight' => 999,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'job' => "",
            'age_from' => 20,
            'age_to' => 28,
            'height_from' => 0,
            'height_to' => 999,
        ]);
        $this->assertDatabaseMissing('user_plan', [
            'user_id' => $this->userId,
            'plan_id' => 1,
        ]);
    }

    /**
     * Test case: R_05_13
     * "- Re-select 'age to' < user's age - 5
    - Click close button in popup https://gyazo.com/6f83842bc56a895d11d0961a52b3b5d1"
     * - Click submit button
     *
     * -> "- 'Age to' automatically return to 'I don't care'
    - 'Age from', 'age to' not highlighted
    - Premium checkbox untick
    - Submit button is valid"
     * "- Go to the next page
    - User still has no plan"
     *
     * expect:
     * -> message: "successful"
     * -> status: 200
     * DB:
     *'job' => "",
     * 'age_from' => 20,
     * 'age_to' => 99,
     * 'height_from' => 0,
     * 'height_to' => 999,
     *
     * 'cost_plan' => null
     * //ERROR: WHEN CHOOSE DEFAULT JOB, THE JOB IS EMPTY THEN API RETURN STATUS 422.
     */
    public function test_male_user_R05_13()
    {
        $this->given_a_logged_in_male_user_40_yo();

        $request = [
            'job' => "",
            'minAge' => 20,
            'maxAge' => 99,
            'minHeight' => 0,
            'maxHeight' => 999,
        ];

        $response = $this->json('POST', '/api/v2/user/registration/2/store', $request);

        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'job' => "",
            'age_from' => 20,
            'age_to' => 99,
            'height_from' => 0,
            'height_to' => 999,
        ]);
        $this->assertDatabaseMissing('user_plan', [
            'user_id' => $this->userId,
            'plan_id' => 1,
        ]);
    }


    /**
     * New male user < 40 y.o (39)
    - Select 'age_to' < user's age - 5 (30)"
     */
    private function given_a_logged_in_male_user_less_than_40_yo_complete_step_2()
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
            'registration_steps' => RegistrationSteps::StepTwo,
            'prefecture_id' => $prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);

        $this->userId = $user->id;

        UserProfile::factory()->create([
            'user_id' => $user->id,
            'birthday' => '1982/01/01',

        ]);

        UserPreference::factory()->create([
            'user_id' => $user->id,
            'age_from' => 20,
            'age_to' => 30,
            'height_from' => 0,
            'height_to' => 999,
        ]);


        $userAuth = UserAuth::factory()->create([
            'user_id' => $user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);

        Passport::actingAs($userAuth);
    }

    /**
     * Test case: R_05_14
     * "- New male user < 40 y.o (39)
     * Select 'age_to' < user's age - 5 (30)"
     * "- Change user's age >= 40 (40)
     * Submit step 1"
     *
     * -> Age_to changes to 'I dont care' (check db)
     *
     * expect:
     * -> message: "successful"
     * -> status: 200
     * DB:
     * 'age_from' => 20,
     * 'age_to' => 99,
     * 'height_from' => 0,
     * 'height_to' => 999,
     *
     * 'cost_plan' => null
     *
     *
     */
    public function test_male_user_R05_14()
    {
        $this->given_a_logged_in_male_user_less_than_40_yo_complete_step_2();

        //User change age to >=40
        $requestStep0 = [
            'email' => 'test@gmail.com',
            'code' => 'promotion code',
            'gender' => UserGender::Male,
            'date' => 1,
            'month' => 1,
            'year' => 1981,
            'prefectureId' => 1,
        ];

        $this->json('POST', '/api/v2/user/registration/0/store', $requestStep0);

        //Then submit step 1
        $requestStep1 = [
            'facePreferences' => "st_03,st_07,st_11,st_06",
        ];
        $response = $this->json('POST', '/api/v2/user/registration/1/store', $requestStep1);


        // check response
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
        // check database
        $this->assertDatabaseHas('user_preference', [
            'user_id' => $this->userId,
            'age_from' => 20,
            'age_to' => 99,
            'height_from' => 0,
            'height_to' => 999,
        ]);
        $this->assertDatabaseMissing('user_plan', [
            'user_id' => $this->userId,
            'plan_id' => 1,
        ]);
    }
}
