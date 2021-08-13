<?php


namespace Tests\Feature\Api\Participation\CancelParticipation;


use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Bachelor\Port\Secondary\Database\PaymentManagement\Plan\ModelDao\Plan;
use Bachelor\Port\Secondary\Database\PaymentManagement\Subscription\ModelDao\Subscription;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\ModelDao\UserTrial;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Utility\Helpers\Utility;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\Feature\Api\Participation\BaseParticipantTest;
use Tests\TestCase;

class TrialMaleUserCancelsParticipationTest extends BaseParticipantTest
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->given_dating_days();
        $this->given_prefecture();
    }

    /**
     * Test case P_09_01
     * "- I am an approved male user
     * I am in trial term
     * I have participation"
     */
    public function given_an_approved_trial_male_user_P_09_01(){
        $this->given_approved_male_user();
        $this->given_active_trial();
        $this->given_participant();
    }

    /**
     * Test case P_09_01
     * WHEN:
     * - I go to participation screen
     * - I cancel my participation"
     *
     * THEN:
     * - My participation is cancelled
     * - My trial is in temp-cancelled status"
     *
     * TEST:
     * -> status: 200
     * -> message: Successful
     * ->database:
     *      'participants_main_matching' => [
     *          'status' => Cancelled,
     *      ]
     *      'user_trials' -> [
     *          'status' => Temp-cancelled
     *      ]
     *
     * ERROR:
     *
     */
    public function test_cancel_participation_P_09_01(){
        $this->given_an_approved_trial_male_user_P_09_01();

        $request = [
          'dateIds' => [
              $this->thisWednesday->id,
          ],
        ];
        $response = $this->json('POST', 'api/v2/participation/cancel-participate', $request);

        //Check response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successful'
        ]);

        //Check database
        $this->assertDatabaseHas('participants_main_matching', [
            'user_id' => $this->user->id,
            'dating_day_id' => $this->thisWednesday->id,
            'status' => ParticipantsStatus::Cancelled,
        ]);
        $this->assertDatabaseHas('user_trials', [
            'user_id' => $this->user->id,
            'status' => TrialStatus::TempCancelled,
        ]);
    }

    /** Test case: P_09_02
     * - I am an unapproved male user
     * - I haven't has subscription
     * - I have participation
     */
    public function given_an_unapproved_male_user_P_09_02(){
        $this->given_unapproved_male_user();
        $this->given_participant();
    }
    protected function given_unapproved_male_user(){
        $mobileNumber = '0123456';
        $authId = Utility::encode($mobileNumber);

        $prefecture = Prefecture::factory()->create([
            'country_id' => 1,
            'admin_id' => 1,
            'name' => 'Name',
            'status' => 1,
        ]);
        $this->user = User::factory()->create([
            'status' => UserStatus::AwaitingUser,
            'gender' => UserGender::Male,
            'registration_steps' => RegistrationSteps::StepFifteenth,
            'mobile_number' => $mobileNumber,
            'prefecture_id' => $prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
            'email' => 'mail@gmail.com',
        ]);
        $userAuth = UserAuth::factory()->create([
            'user_id' => $this->user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);
        Passport::actingAs($userAuth);
    }

    /**
     * Test case P_09_02
     * WHEN:
     * - I go to participation screen
     * - I cancel my participation"
     *
     * THEN:
     * - My participation is cancelled
     *
     *
     * TEST:
     * -> status: 200
     * -> message: Successful
     * ->database:
     *      'participants_main_matching' => [
     *          'status' => Cancelled,
     *      ]
     *
     *
     * ERROR:
     * -> Status code receive is 500.
     * REASON:
     * -> User do not in trial term so user_trial is null. Then it returns error.
     */
    public function test_cancel_participation_P_09_02(){
        $this->given_an_unapproved_male_user_P_09_02();

        $request = [
            'dateIds' => [
                $this->thisWednesday->id,
            ],
        ];
        $response = $this->json('POST', 'api/v2/participation/cancel-participate', $request);
        //Check response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successful'
        ]);

        //Check database
        $this->assertDatabaseHas('participants_main_matching', [
            'user_id' => $this->user->id,
            'dating_day_id' => $this->thisWednesday->id,
            'status' => ParticipantsStatus::Cancelled,
        ]);
    }

    /** Test case: P_09_03
     * - I am an approved female user
     * - I dont have subscription
     * - I have participation
     */
    public function given_an_approved_female_user_P_09_03(){
        $this->given_approved_female_user();
        $this->given_participant();
    }
    protected function given_approved_female_user(){
        $mobileNumber = '0123456';
        $authId = Utility::encode($mobileNumber);

        $this->user = User::factory()->create([
            'status' => UserStatus::ApprovedUser,
            'gender' => UserGender::Female,
            'registration_steps' => RegistrationSteps::StepFifteenth,
            'mobile_number' => $mobileNumber,
            'prefecture_id' => $this->prefecture->id,
            'team_member_rate' => 3,
            'flex_point' => 0,
            'is_fake' => 0,
            'email' => 'mail@gmail.com',
        ]);
        $userAuth = UserAuth::factory()->create([
            'user_id' => $this->user->id,
            'auth_id' => $authId,
            'auth_type' => 'Mobile'
        ]);
        Passport::actingAs($userAuth);
    }
    /**
     * Test case P_09_03
     * WHEN:
     * - I go to participation screen
     * - I cancel my participation"
     *
     * THEN:
     * - My participation is cancelled
     *
     *
     * TEST:
     * -> status: 200
     * -> message: Successful
     * ->database:
     *      'participants_main_matching' => [
     *          'status' => Cancelled,
     *      ]
     *
     *
     * ERROR:
     *
     */
    public function test_cancel_participation_P_09_03(){
        $this->given_an_approved_female_user_P_09_03();

        $request = [
            'dateIds' => [
                $this->thisWednesday->id,
            ],
        ];
        $response = $this->json('POST', 'api/v2/participation/cancel-participate', $request);

        //Check response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successful'
        ]);

        //Check database
        $this->assertDatabaseHas('participants_main_matching', [
            'user_id' => $this->user->id,
            'dating_day_id' => $this->thisWednesday->id,
            'status' => ParticipantsStatus::Cancelled,
        ]);
    }
    /** Test case: P_09_04
     * - I am an approved male user
     * - I have paid subscription
     * - I have participation
     */
    public function given_an_approved_paid_male_user_P_09_04(){
        $this->given_approved_male_user();
        $this->given_participant();
        $this->given_paid_user();
    }

    /**
     * Test case P_09_04
     * WHEN:
     * - I go to participation screen
     * - I cancel my participation"
     *
     * THEN:
     * - My participation is cancelled
     * - My paid subscription keep unchanged
     *
     * TEST:
     * -> status: 200
     * -> message: Successful
     * ->database:
     *      'participants_main_matching' => [
     *          'status' => Cancelled,
     *      ]
     *      'subscription => [
     *          'status => Active,
     *      ]
     *
     * Fail:
     * -> Status code receive is 500.
     * REASON:
     * -> User do not in trial term so user_trial is null. Then it returns error.
     */
    public function test_cancel_participation_P_09_04(){
        $this->given_an_approved_paid_male_user_P_09_04();

        $request = [
            'dateIds' => [
                $this->thisWednesday->id,
            ],
        ];
        $response = $this->json('POST', 'api/v2/participation/cancel-participate', $request);

        //Check response
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Successful'
        ]);

        //Check database
        $this->assertDatabaseHas('participants_main_matching', [
            'user_id' => $this->user->id,
            'dating_day_id' => $this->thisWednesday->id,
            'status' => ParticipantsStatus::Cancelled,
        ]);
        $this->assertDatabaseHas('subscriptions',[
            'user_payment_customer_id' => $this->user->id,
            'third_party_subscription_id' => 'sub_001',
            'status' => SubscriptionStatus::Active,
        ]);
    }

    /** Test case: P_09_05
     * - I am an approved male user
     * - I in trial term
     * - I do not have participation
     */
    public function given_an_approved_trial_male_user_P_09_05(){
        $this->given_approved_male_user();
        $this->given_active_trial();
    }

    /**
     * Test case P_09_05
     * WHEN:
     * - I go to participation screen
     *
     *
     * THEN:
     * - I can NOT cancel participation
     *
     * TEST:
     *
     *
     *
     * Fail:
     * -> status code still 200 and message "successful"
     *
     */
    public function test_cancel_participation_P_09_05(){
        $this->given_an_approved_trial_male_user_P_09_05();

        $request = [
            'dateIds' => [
                $this->thisWednesday->id,
            ],
        ];
        $response = $this->json('POST', 'api/v2/participation/cancel-participate', $request);
        $this->assertDatabaseMissing('participants_main_matching',[
            'user_id' => $this->user->id,
            'dating_day_id' => $this->thisWednesday->id,
        ]);
    }

}
