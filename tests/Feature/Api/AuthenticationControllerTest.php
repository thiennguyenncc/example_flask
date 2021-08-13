<?php


namespace Api;


use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Utility\Helpers\Utility;
use Bachelor\Utility\Http\Interfaces\HttpClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * As a user who signed up with the phone number, I want to sign in with my phone number.
     */
    public function test_passport_oauth()
    {
        $mobileNumber = '0123456';
        $authId = Utility::encode($mobileNumber);
        $secret = Str::random(40);
        $client = \Laravel\Passport\Client::factory()->create([
            'user_id' => null,
            'name' => 'Name',
            'secret' => $secret,
            'redirect' => '',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ]);

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
            'status' => UserStatus::IncompleteUser,
            'registration_steps' => RegistrationSteps::StepZero,
            'prefecture_id' => $prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);


        UserAuth::factory()->create([
            'user_id' => $user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);

        $request = [
            'grant_type' => "password",
            'client_id' => $client->id,
            'client_secret' => $secret,
            'username' => $authId,
            'password' => "password" . $authId,
            'scope' => ""
        ];

        $response = $this->json('POST', '/oauth/token', $request);

        $response->assertJsonFragment(["token_type" => "Bearer"]);

        $accessToken = $response->json('access_token');

        $response = $this->get('/api/v2/user/get-profile-info', [
            'Authorization' => 'Bearer ' . $accessToken
        ]);

        $response->assertJsonFragment(["message" => "Successful"]);
    }

    /**
     * As a user who signed up with the phone number, I want to sign in with my phone number.
     *
     * with mock passport auth response
     */
    public function test_social_login_successful()
    {
        $mobileNumber = '0123456';
        $authId = Utility::encode($mobileNumber);

        $this->app->bind(HttpClientInterface::class, function($app){
            $mock = new MockHandler([
                new Response(200, [],json_encode([
                    'token_type' => 'Bearer',
                    'expires_in' => 123123,
                    'access_token' => 'access_token',
                    'refresh_token' => 'refresh_token'
                ])),
            ]);

            $handlerStack = HandlerStack::create($mock);
            return new Client(['handler' => $handlerStack]);
        });

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
            'status' => UserStatus::IncompleteUser,
            'registration_steps' => RegistrationSteps::StepZero,
            'prefecture_id' => $prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
        ]);

        UserAuth::factory()->create([
            'user_id' => $user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);

        $this->assertDatabaseHas('user_auth',[
            'user_id' => $user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);

        $response = $this->json('POST', '/api/v2/social-login', [
            'authId' => $authId,
            'authType' => 'Mobile'
        ]);

        $response->assertJsonFragment([
            'message' => 'User Login Successfully'
        ]);
    }
}
