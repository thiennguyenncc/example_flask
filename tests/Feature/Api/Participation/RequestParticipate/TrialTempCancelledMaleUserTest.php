<?php

namespace Tests\Feature\Api\Participation\RequestParticipate;


use Carbon\Carbon;
use Database\Seeders\CouponSeeder;
use Database\Seeders\ParticipantAwaitingCancelSettingForTestingSeeder;
use Database\Seeders\ParticipantAwaitingCountSettingForTestingSeeder;
use Database\Seeders\ParticipationOpenExpirySettingForTestingExistingUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\Participation\BaseParticipantTest;

class TrialTempCancelledMaleUserTest extends BaseParticipantTest
{
    /**
     * Test case: P_10
     */
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CouponSeeder::class);
        $this->seed(ParticipationOpenExpirySettingForTestingExistingUserSeeder::class);
        $this->seed(ParticipantAwaitingCountSettingForTestingSeeder::class);
        $this->seed(ParticipantAwaitingCancelSettingForTestingSeeder::class);
        $this->given_dating_days();
        $this->given_prefecture();
        $this->monday = Carbon::now()->startOfWeek()->addHour();
        $this->given_approved_trial_temp_cancelled_male_user();
    }

    /**
     * "- I am approved male user
     * - I am in trial term
     * - My trial is in temp-cancelled status
     * - I have NOT active participation (status partcipation =1)"
     */
    public function given_approved_trial_temp_cancelled_male_user()
    {
        $this->given_approved_male_user();
        $this->given_temp_cancelled_trial();
    }

    /**
     * Test case P_10_01
     * WHEN:
     * "- It's Monday this week
     * - I go to participation screen"
     *
     * THEN:
     * "- I can participate only one of the following day (opened date):
    + Wednesday,Saturday, Sunday this week
    -I can't participate Wednesday, Saturday, Sunday next week,Wednesday Saturday, Sunday next next week (closed)
    - My trial is updated:
    + trial_start: null
    + trial_end = 23:59:59 dating day"
     *
     * RESULT:
     * - I can participate from this Sat to next next Wed.
     * - Trial end not change to 23:59:59 dating date
     */
    public function test_participate_mon()
    {
        //Today is Monday
        Carbon::setTestNow($this->monday);

        $response = $this->json('POST', 'api/v2/participation/request-participate',[
           'dateIds' => [$this->nextNextWednesday->id,]
        ]);

        $response->assertOk();
        $response->assertJson([
            'message' => 'Successful',
        ]);
    }

    /**
     * Test case: P_10_02
     * WHEN:
     *"- It's Tue, Wed, Thursday this week
     * - I go to participation screen"
     *
     * THEN:
    "- I can participate only one of the following day (opened date):
    + Saturday,Sunday this week
    + Wednesday next week
    - I can't participate on Wednesday  this week (expired); Saturday, Sunday next week,Wednesday, Saturday,Sunday next next week (closed)
    - My trial is updated:
    + trial_start = null
    + trial_end = 23:59:59 dating day"
     *
     * RESULT:
     * - participate on thursday NOT return same result as tuesday and wednesday.
     */
    public function test_participate_thursday()
    {
        //Today is Thursday
        Carbon::setTestNow($this->monday->copy()->addDays(3));
        $this->then_expect_result_on_tue_wed_thu();

    }
    public function test_participate_tue()
    {
        //Today is Tuesday
        Carbon::setTestNow($this->monday->copy()->addDay());
        $this->then_expect_result_on_tue_wed_thu();
    }
    public function test_participate_wed()
    {
        //Today is Wednesday
        Carbon::setTestNow($this->monday->copy()->addDays(2));
        $this->then_expect_result_on_tue_wed_thu();

    }
    public function then_expect_result_on_tue_wed_thu(){
        $response = $this->json('POST', 'api/v2/participation/request-participate',[
            'dateIds' => [$this->thisSaturday->id]
        ]);
        $response->assertOk();
        $response->assertJson([
            'message' => 'Successful',
        ]);
    }

    /**
     * Test case: P_10_04
     * WHEN:
     *"- It's Saturday to Sunday this week
     * - I go to participation screen"
     *
     * THEN:
    "- I can participate only one of the following day (opened date):
    + Wednesday, Saturday, Sunday next week
    - I can't participate on Wednesday, Saturday, Sunday this week (expired)
    Wednesday, Saturday, Sunday next next week(closed)

    - My trial is updated:
    + trial_start = null
    + trial_end = 23:59:59 dating day"
     *
     * RESULT:
     * - I can participate form next Wed to next next Sun
     */
    public function test_participate_sat()
    {
        //Today is saturday
        Carbon::setTestNow($this->monday->copy()->addDays(5));
        $this->then_expect_result_on_sat_sun();
    }
    public function test_participate_sun()
    {
        //Today is sunday
        Carbon::setTestNow($this->monday->copy()->addDays(6));
        $this->then_expect_result_on_sat_sun();
    }
    public function then_expect_result_on_sat_sun(){
//      I can participate only one of the following day (opened date):
//      Wednesday, Saturday, Sunday next week
//      I can't participate on Wednesday, Saturday, Sunday this week (expired)
//      Wednesday, Saturday, Sunday next next week(closed)
        $response = $this->json('POST', 'api/v2/participation/request-participate',[
            'dateIds' => [$this->nextNextSunday->id]
        ]);
        $response->assertOk();
        $response->assertJson([
            'message' => 'Successful',
        ]);
    }



}
