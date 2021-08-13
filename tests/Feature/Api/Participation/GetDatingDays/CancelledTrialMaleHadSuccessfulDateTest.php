<?php


namespace Tests\Feature\Api\Participation\GetDatingDays;


use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Enums\ParticipationOpenExpireStatus;
use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\UserCoupon\Enum\UserCouponStatus;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\ModelDao\Coupon;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentProvider\ModelDao\PaymentProvider;
use Bachelor\Port\Secondary\Database\PaymentManagement\Subscription\ModelDao\Subscription;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\ModelDao\UserPaymentCustomer;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\ModelDao\UserTrial;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao\UserCoupon;
use Bachelor\Utility\Helpers\Utility;
use Carbon\Carbon;
use Database\Seeders\CouponSeeder;
use Database\Seeders\ParticipantAwaitingCancelSettingForTestingSeeder;
use Database\Seeders\ParticipantAwaitingCountSettingForTestingSeeder;
use Database\Seeders\ParticipationOpenExpirySettingForTestingNewUserSeeder;
use Illuminate\Testing\TestResponse;
use Laravel\Passport\Passport;
use Tests\Feature\Api\Participation\BaseParticipantTest;

/**
 * P_14
 * @package Api\Participation
 */
class CancelledTrialMaleHadSuccessfulDateTest extends BaseParticipantTest
{
    /**
     * As a cancelled trial male user having successful date
     * and using dating coupon
     * I can participate multiple opened dates in a week
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CouponSeeder::class);
        $this->seed(ParticipationOpenExpirySettingForTestingNewUserSeeder::class);
        $this->seed(ParticipantAwaitingCountSettingForTestingSeeder::class);
        $this->seed(ParticipantAwaitingCancelSettingForTestingSeeder::class);


        $this->given_prefecture();
        $this->given_dating_place();
        $this->given_a_canceled_trial_reapproved_male_logged_in_user();
        $this->monday = Carbon::now()->startOfWeek()->addHours(1);
        $this->given_dating_days();
        $this->given_paid_user();
        $this->given_coupon();
    }

    private function given_a_canceled_trial_reapproved_male_logged_in_user()
    {
        $this->given_approved_male_user();
        $this->given_temp_cancelled_trial();
    }


    /**
     * P_14_01
     * "- I change from trial to paid user
     * - I can participate 1 free date (for next week) + X dates (X: the number of dating coupons user used) in a week
     * - I can participate these following opened days:
     * + Saturday, Sunday this week
     * + Wednesday next week
     * - I can't participate Wednesday this week (expired)
     * - I can't participate Saturday, Sunday next week (closed)"
     *
     * RESULT:
     * expired: this Wed, Sat
     * opened: this Sun; next Wed, Sat, Sun; next next Wed, Sat
     * closed: next next Sun
     */
    public function test_opens_app_on_thursday()
    {
        $this->given_participant_and_dating_this_week();
        $this->given_feedback();

        // today is thursday
        Carbon::setTestNow($this->monday->copy()->addDays(3));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_tue_wed_thu($response);
    }

    /**
     * P_14_02
     * "- I change from trial to paid user
     * - I can participate 1 free date (for next week) + X dates (X: the number of dating coupons user used) in a week
     * - I can participate these following opened days:
     * + Sunday this week
     * + Wednesday, Saturday next week
     * - I can't participate Wednesday, Saturday this week (expired)
     * - I can't participate Sunday this week (closed)"
     *
     * RESULT:
     * expired: this Wed, Sat, Sun
     * opened: next Wed, Sat, Sun; next next Wed, Sat, Sun.
     * closed:
     */
    public function test_opens_app_on_friday()
    {
        $this->given_participant_and_dating_this_week();
        $this->given_feedback();

        // today is friday
        Carbon::setTestNow($this->monday->copy()->addDays(4));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_fri($response);
    }

    /**
     * P_14_03
     * "- I change from trial to paid user
     * - I can participate 1 free date (for next week) + X dates (X: the number of dating coupons user used) in a week
     * - I can participate these following opened days:
     * + Wednesday, Saturday, Sunday next week"
     *
     * RESULT:
     * expired: this Wed, Sat, Sun
     * opened: next Wed, Sat, Sun; next next Wed, Sat, Sun
     * closed:
     */
    public function test_opens_app_on_sat_sun()
    {
        $this->given_participant_and_dating_this_week();
        $this->given_feedback();
        // today is saturday
        Carbon::setTestNow($this->monday->copy()->addDays(5));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_saturday_sunday($response);


        //today is sunday
        Carbon::setTestNow($this->monday->copy()->addDays(6));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_saturday_sunday($response);
    }

    /**
     * P_14_04
     * "- I change from trial to paid user
     * - I can participate 1 for this week + X dates (X: the number of dating coupons user used) in a week
     * - I can participate these following opened days:
     * + Wednesday, Saturday, Sunday this week"
     *
     * RESULT:
     * Expired: this wed
     * Opened: this sat, sun; next wed, sat, sun; next next wed.
     * Closed: next next sat, sun
     */
    public function test_opens_app_on_monday()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();
        // today is Monday
        Carbon::setTestNow($this->monday->copy());
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_monday($response);
    }

    private function then_expect_result_on_monday(TestResponse $response)
    {
        $response->assertOk();
        $weeks = $response['data']['weeks'];
        //  I can participate these following opened days:
        //+ Wednesday, Saturday, Sunday this week

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[1][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[1][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[1][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][2]['open_expiry_status']);
    }

    /**
     * P_14_05
     * "- I change from trial to paid user
     * - I can participate 2 free dates (1 this week & 1 next week) + X dates (X: the number of dating coupons user used)
     * - I can participate these following opened days:
     * + Saturday, Sunday this week
     * + Wednesday next week
     * - I can't participate Wednesday this week (expired)
     * - I can't participate Saturday, Sunday next week (closed)"
     *
     * RESULT:
     * expired: this Wed
     * opened: this Sat, Sun; next Wed, Sat, Sun; next next Wed
     * closed: next next Sat, Sun
     */
    public function test_opens_app_on_tue_wed_thu()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();

        // today is Tuesday
        Carbon::setTestNow($this->monday->copy()->addDay());
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_tue_wed_thu($response);

        // today is Wednesday
        Carbon::setTestNow($this->monday->copy()->addDays(2));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_tue_wed_thu($response);

        // today is Thursday
        Carbon::setTestNow($this->monday->copy()->addDays(3));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_tue_wed_thu($response);
    }

    private function then_expect_result_on_tue_wed_thu(TestResponse $response)
    {
        $response->assertOk();
        $weeks = $response['data']['weeks'];
        //  I can participate these following opened days:
        //+ this sat, sun and next wed

        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[1][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[1][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][2]['open_expiry_status']);
    }

    /**
     * P_14_06
     * "- I change from trial to paid user
     * - I can participate 2 free dates (1 this week & 1 next week) + X dates (X: the number of dating coupons user used)
     * - I can participate these following opened days:
     * + Sunday this week
     * + Wednesday, Saturday next week
     * - I can't participate Wednesday, Saturday this week (expired)
     * - I can't participate Sunday next week (closed)"
     *
     * RESULT:
     * expired: this Wed, Sat, Sun
     * opened: next Wed, Sat, Sun; next next Wed, Sat, Sun
     * closed:
     */
    public function test_male_user_opens_app_on_friday()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();
        // today is Friday
        Carbon::setTestNow($this->monday->copy()->addDays(4));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_fri($response);
    }

    private function then_expect_result_on_fri(TestResponse $response)
    {
        $response->assertOk();
        $weeks = $response['data']['weeks'];
//      I can participate these following opened days:
//    + Sunday this week
//    + Wednesday, Saturday next week
//    - I can't participate Wednesday, Saturday this week (expired)
//    - I can't participate Sunday next week (closed)"

        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[0][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[1][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][2]['open_expiry_status']);
    }

    /**
     * P_14_07
     * "- I change from trial to paid user
     * - I can participate 1 free date + X dates (X: the number of dating coupons user used) in a week
     * - I can participate these following opened days:
     * + Wednesday, Saturday, Sunday next week"
     *
     * RESULT:
     * expired: this Wed, Sat, Sun
     * opened: next Wed, Sat, Sun; next next Wed, Sat, Sun
     * closed:
     */
    public function test_male_user_opens_app_on_sat_sun()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();
        // today is saturday
        Carbon::setTestNow($this->monday->copy()->addDays(5));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_saturday_sunday($response);

        //today is Sunday
        Carbon::setTestNow($this->monday->copy()->addDays(6));
        $response = $this->json('GET', '/api/v2/participation/get-dating-days');
        $this->then_expect_result_on_saturday_sunday($response);
    }

    private function then_expect_result_on_saturday_sunday(TestResponse $response)
    {
        $response->assertOk();
        $weeks = $response['data']['weeks'];
        //I can participate these following opened days:
        //    + Wednesday, Saturday, Sunday next week"

        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Expired, $weeks[0][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Opened, $weeks[1][2]['open_expiry_status']);

        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][0]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][1]['open_expiry_status']);
        $this->assertEquals(ParticipationOpenExpireStatus::Closed, $weeks[2][2]['open_expiry_status']);
    }


}

