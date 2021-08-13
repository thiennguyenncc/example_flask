<?php


namespace Tests\Feature\Api\Participation\RequestParticipate;


use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;

use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;

use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;

use Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\ModelDao\UserTrial;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;

use Bachelor\Utility\Helpers\Utility;
use Database\Seeders\CouponSeeder;
use Database\Seeders\ParticipantAwaitingCancelSettingForTestingSeeder;
use Database\Seeders\ParticipantAwaitingCountSettingForTestingSeeder;
use Database\Seeders\ParticipationOpenExpirySettingForTestingExistingUserSeeder;
use Illuminate\Support\Carbon;

use Laravel\Passport\Passport;

use Tests\Feature\Api\Participation\BaseParticipantTest;

class ReactivateTrialMaleUserTest extends BaseParticipantTest
{
    /**
     * P_16
     * As a reactivated trial male user
     * I can participate only 1 opened date from this week to next next week
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CouponSeeder::class);
        $this->seed(ParticipationOpenExpirySettingForTestingExistingUserSeeder::class);
        $this->seed(ParticipantAwaitingCountSettingForTestingSeeder::class);
        $this->seed(ParticipantAwaitingCancelSettingForTestingSeeder::class);

        $this->monday = Carbon::now()->startOfWeek()->addHours(1);
        $this->given_dating_days();
        $this->given_prefecture();
        $this->given_reactivated_trial_male_logged_in_user();
    }

    private function given_reactivated_trial_male_logged_in_user()
    {
        $this->given_approved_male_user();
        $this->given_active_trial();
    }

    /**
     * P_16_01
     * GIVEN:
     * - I am a deactivated trial male user
     * - I am reactivated
     * - I have NOT had successful date after being reactivated
     * - I have NOT completed 2nd registration form
     * - I do NOT have participation"
     * WHEN:
     * - It's  Monday or Tuesday or Wednesday this week
     * - I go to participation screen"
     *
     * THEN:
     * - I can participate only one of the following days (opened date):
     * + Saturday, Sunday this week
     * + Wednesday, Saturday, Sunday next week
     * + Wednesday next next week
     * - I can't participate Wednesday this week (closed); Saturday, Sunday next next week (closed)"
     */
    public function test_reactivated_male_user_open_app_on_mon()
    {
        //today is monday
        Carbon::setTestNow($this->monday);
        $this->then_expect_result_not_successful_mon_tue_wed();
        $this->then_expect_result_successful_mon_tue_wed();
    }

    public function test_reactivated_male_user_open_app_on_tue()
    {
        //today is tue
        Carbon::setTestNow($this->monday->copy()->addDay());
        $this->then_expect_result_not_successful_mon_tue_wed();
        $this->then_expect_result_successful_mon_tue_wed();
    }

    public function test_reactivated_male_user_open_app_on_wed()
    {
        //today is wednesday
        Carbon::setTestNow($this->monday->copy()->addDays(2));
        $this->then_expect_result_not_successful_mon_tue_wed();
        $this->then_expect_result_successful_mon_tue_wed();
    }

    public function then_expect_result_successful_mon_tue_wed()
    {
//      I can participate only one of the following days (opened date):
//      Saturday, Sunday this week
//      Wednesday, Saturday, Sunday next week
//      Wednesday next next week
        $response = $this->json('POST', 'api/v2/participation/request-participate',
            [
                'dateIds' => [$this->nextNextWednesday->id,]
            ]);
        $response->assertOk();
        $response->assertJson([
            'message' => 'Successful',
        ]);
    }

    public function then_expect_result_not_successful_mon_tue_wed()
    {
//      I can't participate Wednesday this week (closed); Saturday, Sunday next next week (closed)"
        $response = $this->json('POST', 'api/v2/participation/request-participate',
            [
                'dateIds' => [$this->thisWednesday->id,]
            ]);
        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'The date you requested is closed',
        ]);
    }

    /**
     * P_16_02
     * GIVEN:
     * - I am a deactivated trial male user
     * - I am reactivated
     * - I have NOT had successful date after being reactivated
     * - I have NOT completed 2nd registration form
     * - I do NOT have participation"
     * WHEN:
     * - It's Thursday this week
     * - I go to participation screen"
     *
     * THEN:
     * - I can participate only one of the following days (opened date):
     * + Sunday this week
     * + Wednesday, Saturday, Sunday next week
     * + Wednesday, Saturday next next week
     * - I can't participate on Wednesday, Saturday this week (expired); Sunday next next week (closed)"
     */
    public function test_reactivated_male_user_open_app_on_thu()
    {
        //today is thursday
        Carbon::setTestNow($this->monday->copy()->addDays(3));
        $this->then_expect_result_not_successful_thu();
        $this->then_expect_result_successful_thu();
    }

    public function then_expect_result_successful_thu()
    {
//      Sunday this week
//    + Wednesday, Saturday, Sunday next week
//    + Wednesday, Saturday next next week
        $response = $this->json('POST', 'api/v2/participation/request-participate',
            [
                'dateIds' => [$this->nextNextSaturday->id,]
            ]);
        $response->assertOk();
        $response->assertJson([
            'message' => 'Successful',
        ]);
    }

    public function then_expect_result_not_successful_thu()
    {
//      I can't participate on Wednesday, Saturday this week (expired); Sunday next next week (closed)"
        $response = $this->json('POST', 'api/v2/participation/request-participate',
            [
                'dateIds' => [$this->nextNextSunday->id,]
            ]);
        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'The date you requested is closed',
        ]);
    }

    /**
     * p_16_03
     * GIVEN:
     * - I am a deactivated trial male user
     * - I am reactivated
     * - I have NOT had successful date after being reactivated
     * - I have NOT completed 2nd registration form
     * - I do NOT have participation"
     *
     * WHEN:
     * - It's Friday, Saturday, Sunday this week
     * - I go to participation screen"
     *
     * THEN:
     * - I can participate only one of the following days (opened date):
     * + Wednesday, Saturday, Sunday next week
     * + Wednesday, Saturday, Sunday next next week
     * - I can't participate Wednesday, Saturday, Sunday this week (expired)"
     */
    public function test_reactivated_male_user_open_app_on_fri()
    {
        //today is friday
        Carbon::setTestNow($this->monday->copy()->addDays(4));
        $this->then_expect_result_not_successful_fri_sat_sun();
        $this->then_expect_result_successful_fri_sat_sun();
    }

    public function test_reactivated_male_user_open_app_on_sat()
    {
        //today is saturday
        Carbon::setTestNow($this->monday->copy()->addDays(5));
        $this->then_expect_result_not_successful_fri_sat_sun();
        $this->then_expect_result_successful_fri_sat_sun();
    }

    public function test_reactivated_male_user_open_app_on_sun()
    {
        //today is sunday
        Carbon::setTestNow($this->monday->copy()->addDays(6));
        $this->then_expect_result_not_successful_fri_sat_sun();
        $this->then_expect_result_successful_fri_sat_sun();
    }

    public function then_expect_result_successful_fri_sat_sun()
    {
//      I can participate only one of the following days (opened date):
//      Wednesday, Saturday, Sunday next week
//      Wednesday, Saturday, Sunday next next week
        $response = $this->json('POST', 'api/v2/participation/request-participate',
            [
                'dateIds' => [$this->nextNextSunday->id,]
            ]);
        $response->assertOk();
        $response->assertJson([
            'message' => 'Successful',
        ]);
    }

    public function then_expect_result_not_successful_fri_sat_sun()
    {
//      I can't participate Wednesday, Saturday, Sunday this week (expired)"
        $response = $this->json('POST', 'api/v2/participation/request-participate',
            [
                'dateIds' => [$this->thisSunday->id,]
            ]);
        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'The date you requested is closed',
        ]);
    }

    /**
     * P_16_04
     * GIVEN:
     * - I am a deactivated trial male user
     * - I am reactivated
     * - I have NOT had successful date after being reapproved
     * - I have participation"
     * WHEN:
     * - It's from Monday to Sunday this week
     * - I go to participation screen"
     * THEN:
     * - I can NOT participate MORE opened date
     * - I can only change participation date to another opened date"
     */
    public function test_male_user_have_participant()
    {
        $this->given_participant();
        $response = $this->json('POST', 'api/v2/participation/request-participate', [
            'dateIds' => [$this->thisSunday->id,]
        ]);
        $response->assertStatus(500);
        $response->assertJson([
            'message' => 'You do not have permission to participate!',
        ]);
    }
}
