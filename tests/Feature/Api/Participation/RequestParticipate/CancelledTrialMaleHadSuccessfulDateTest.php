<?php


namespace Tests\Feature\Api\Participation\RequestParticipate;


use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
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
use Database\Seeders\CouponSeeder;
use Database\Seeders\ParticipantAwaitingCancelSettingForTestingSeeder;
use Database\Seeders\ParticipantAwaitingCountSettingForTestingSeeder;
use Database\Seeders\ParticipationOpenExpirySettingForTestingExistingUserSeeder;
use Illuminate\Support\Carbon;
use Laravel\Passport\Passport;
use Tests\Feature\Api\Participation\BaseParticipantTest;

/**
 * Class CancelledTrialMaleTest
 * P_14
 * @package Api\Participation\requestParticipateMainMatch
 */
class CancelledTrialMaleHadSuccessfulDateTest extends BaseParticipantTest
{
    /**
     * - I am a cancelled trial male user
     * - I am reapproved
     * - I have had successful date after being reapproved in Wednesday this week
     * - I've sent feedback
     * - I do NOT have open invoice
     * - I have dating coupons
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
        $this->given_dating_place();
        $this->given_a_canceled_trial_reapproved_male_logged_in_user();
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
     * GIVEN:
     * "- I am a cancelled trial male user
    - I am reapproved
    - I have had successful date after being reapproved in Wednesday this week
    - I've sent feedback
    - I do NOT have open invoice
    - I have dating coupons"

WHEN:
     * "- It's Thursday this week
    - I use X dating coupon to participate on opened date"
     * THEN:
     *
     * "- I change from trial to paid user
    - I can participate 1 free date (for next week) + X dates (X: the number of dating coupons user used) in a week
    - I can participate these following opened days:
    + Saturday, Sunday this week
    + Wednesday next week
    - I can't participate Wednesday this week (expired)
    - I can't participate Saturday, Sunday next week (closed)"
     *
     * RESULT:
     * - Can't participate date in this week
     * - Can't participate multiple date
     */
    public function test_male_opens_app_on_thursday()
    {
        // today is Thursday
        Carbon::setTestNow($this->monday->copy()->addDays(3));
        $this->given_participant_and_dating_this_week();
        $this->given_feedback();

        $dateIds = [
            $this->thisSunday->id,
            $this->nextWednesday->id,
        ];
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
    }

    /**
     * P_14_02
     * WHEN:
     * "- It's Friday this week
    - I use X dating coupon to participate on opened date"
     * THEN:
     * "- I change from trial to paid user
    - I can participate 1 free date (for next week) + X dates (X: the number of dating coupons user used) in a week
    - I can participate these following opened days:
    + Sunday this week
    + Wednesday, Saturday next week
    - I can't participate Wednesday, Saturday this week (expired)
    - I can't participate Sunday this week (closed)"
     *
     * RESULT:
     * - Can't participate multiple date.
     * - This Sunday is closed or opened?
     */
    public function test_male_opens_app_on_friday()
    {
        // today is Friday
        $this->given_participant_and_dating_this_week();
        $this->given_feedback();
        Carbon::setTestNow($this->monday->copy()->addDays(4));

        $dateIds = [
          $this->nextSaturday->id,
          $this->nextWednesday->id,
        ];
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
    }

    /**
     * P_14_03
     *
     * WHEN:
     * "- It's from Saturday to Sunday this week
    - I use X dating coupon to participate on opened date"
     * THEN:
     * "- I change from trial to paid user
    - I can participate 1 free date (for next week) + X dates (X: the number of dating coupons user used) in a week
    - I can participate these following opened days:
    + Wednesday, Saturday, Sunday next week"
     *
     * RESULT:
     * - Can't participate multiple date
     * -
     */
    public function test_male_opens_app_on_saturday()
    {
        $this->given_participant_and_dating_this_week();
        $this->given_feedback();

        $dateIds = [
            $this->nextWednesday->id,
            $this->nextSaturday->id,
        ];
        // today is Saturday
        Carbon::setTestNow($this->monday->copy()->addDays(5));
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
    }
    public function test_male_opens_app_on_sunday()
    {
        $this->given_participant_and_dating_this_week();
        $this->given_feedback();

        $dateIds = [
            $this->nextSaturday->id,
            $this->nextSunday->id,
        ];
        // today is Sunday
        Carbon::setTestNow($this->monday->copy()->addDays(6));
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
    }

    /**
     * P_14_04
     *
     * GIVEN
     *"- I am a cancelled trial male user
     * - I am reapproved
     * - I have had successful date after being reapproved
     * - My successful date is NOT in this week
     * - I've sent feedback
     * - I do NOT have uncollective invoice
     * - I use X dating coupon"
     *
     * WHEN
     * "- It's Monday this week
     * - I go to participation screen"
     *
     * THEN
     * "- I change from trial to paid user
     * - I can participate 1 for this week + X dates (X: the number of dating coupons user used) in a week
     * - I can participate these following opened days:
     * + Wednesday, Saturday, Sunday this week"
     *
     * RESULT:
     * - Can't participate more dating day, this Wednesday is closed.
     */
    public function test_male_opens_app_on_monday()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();
        $dateIds = [
            $this->thisWednesday->id,
        ];

        //Today is monday
        Carbon::setTestNow($this->monday);
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
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
     * - I still can participate on next Sat.
     * - I can't participate more than 2 date even use coupon
     */
    public function test_male_opens_app_on_tue()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();
        $dateIds = [
            $this->thisSaturday->id,
            $this->nextWednesday->id,
        ];

        //Today is tuesday
        Carbon::setTestNow($this->monday->copy()->addDay());
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
    }

    public function test_male_opens_app_on_wed()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();
        $dateIds = [
            $this->thisSunday->id,
            $this->thisSaturday->id,
        ];

        //Today is wednesday
        Carbon::setTestNow($this->monday->copy()->addDays(2));
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
    }

    public function test_male_opens_app_on_thu()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();
        $dateIds = [
            $this->thisSunday->id,
            $this->thisSaturday->id,
        ];

        //Today is thursday
        Carbon::setTestNow($this->monday->copy()->addDays(3));
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
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
     * Sunday this week is closed. Can't participate multiple date.
     */
    public function test_male_opens_app_on_fri()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();
        $dateIds = [
            $this->thisSunday->id,
            $this->nextSunday->id,
            $this->nextWednesday->id,

        ];

        //Today is friday
        Carbon::setTestNow($this->monday->copy()->addDays(4));
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
    }

    /**
     * P_14_07
     * "- I change from trial to paid user
     * - I can participate 1 free date + X dates (X: the number of dating coupons user used) in a week
     * - I can participate these following opened days:
     * + Wednesday, Saturday, Sunday next week"
     */
    public function test_male_opens_app_on_sat()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();
        $dateIds = [
            $this->nextSunday->id,
            $this->nextWednesday->id,

        ];

        //Today is saturday
        Carbon::setTestNow($this->monday->copy()->addDays(5));
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
    }

    public function test_male_opens_app_on_sun()
    {
        $this->given_participant_and_dating_last_week();
        $this->given_feedback();
        $dateIds = [
            $this->nextSunday->id,
            $this->nextWednesday->id,
        ];

        //Today is sunday
        Carbon::setTestNow($this->monday->copy()->addDays(6));
        $this->then_i_can_participate_more_than_one_day_next_week($dateIds);
    }

    private function then_i_can_not_participate_more_than_one_day(array $dateIds)
    {
        $response = $this->json('POST', '/api/v2/participation/request-participate',
            [
                'dateIds' => $dateIds
            ]);
        $response->assertStatus(500);
        $response->assertJsonFragment([
            'message' => 'You need more coupons to have multiple date!'
        ]);
    }

    private function then_i_can_participate_more_than_one_day_next_week(array $dateIds)
    {
        $response = $this->json('POST', '/api/v2/participation/request-participate',
            [
                'dateIds' => $dateIds
            ]);
        $response->assertOk();
        $response->assertJsonFragment([
            'message' => 'Successful',
        ]);
    }

}
