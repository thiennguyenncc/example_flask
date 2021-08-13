<?php


namespace Tests\Feature\Api\Participation;

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
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao\Feedback;
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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BaseParticipantTest extends TestCase
{
    use RefreshDatabase;
    protected Carbon $monday;
    protected DatingDay $lastWednesday;
    protected DatingDay $thisWednesday;
    protected DatingDay $thisSaturday;
    protected DatingDay $thisSunday;
    protected DatingDay $nextWednesday;
    protected DatingDay $nextSaturday;
    protected DatingDay $nextSunday;
    protected DatingDay $nextNextWednesday;
    protected DatingDay $nextNextSaturday;
    protected DatingDay $nextNextSunday;
    protected Dating $dating;
    protected User $user;
    protected Prefecture $prefecture;
    protected DatingPlace $datingPlace;

    protected function given_dating_days()
    {
        $this->monday = Carbon::now()->startOfWeek();
        //lastweek
        $this->lastWednesday = DatingDay::factory()->create([
            'dating_day' => 'wednesday',
            'dating_date' => $this->monday->copy()->addDay(-5)->format('Y-m-d')
        ]);

        //this week
        $this->thisWednesday = DatingDay::factory()->create([
            'dating_day' => 'wednesday',
            'dating_date' => $this->monday->copy()->addDay(2)->format('Y-m-d')
        ]);

        $this->thisSaturday = DatingDay::factory()->create([
            'dating_day' => 'saturday',
            'dating_date' => $this->monday->copy()->addDay(5)->format('Y-m-d')
        ]);

        $this->thisSunday = DatingDay::factory()->create([
            'dating_day' => 'sunday',
            'dating_date' => $this->monday->copy()->addDay(6)->format('Y-m-d')
        ]);
        //next week
        $this->nextWednesday = DatingDay::factory()->create([
            'dating_day' => 'wednesday',
            'dating_date' => $this->monday->copy()->addDay(9)->format('Y-m-d')
        ]);

        $this->nextSaturday = DatingDay::factory()->create([
            'dating_day' => 'saturday',
            'dating_date' => $this->monday->copy()->addDay(12)->format('Y-m-d')
        ]);

        $this->nextSunday = DatingDay::factory()->create([
            'dating_day' => 'sunday',
            'dating_date' => $this->monday->copy()->addDay(13)->format('Y-m-d')
        ]);
        //next next week
        $this->nextNextWednesday = DatingDay::factory()->create([
            'dating_day' => 'wednesday',
            'dating_date' => $this->monday->copy()->addDay(16)->format('Y-m-d')
        ]);

        $this->nextNextSaturday = DatingDay::factory()->create([
            'dating_day' => 'saturday',
            'dating_date' => $this->monday->copy()->addDay(19)->format('Y-m-d')
        ]);

        $this->nextNextSunday = DatingDay::factory()->create([
            'dating_day' => 'sunday',
            'dating_date' => $this->monday->copy()->addDay(20)->format('Y-m-d')
        ]);
    }
    protected function given_paid_user()
    {
        $paymentProvider = PaymentProvider::factory()->create([
            'name' => 'Name',
        ]);
        $userPaymentCustomer = UserPaymentCustomer::factory()->create([
            'user_id' => $this->user->id,
            'payment_provider_id' => $paymentProvider->id,
            'third_party_customer_id' => 'cus_001',
            'default_payment_card_id' => 1,
        ]);
        Subscription::factory()->create([
            'user_payment_customer_id' => $userPaymentCustomer->id,
            'third_party_subscription_id' => 'sub_001',
            'starts_at' => Carbon::now(),
            'next_starts_at' => \Illuminate\Support\Carbon::now()->addMonth(),
            'status' => SubscriptionStatus::Active(),
        ]);
    }
    protected function given_feedback()
    {
        Feedback::factory()->create([
            'dating_id' => $this->dating->id,
            'feedback_by' => $this->user->id,
            'feedback_for' => $this->user->id,
            'dating_place_review' => 5,
            'calculateable_dating_report' => 5,
            'last_satisfaction' => 5
        ]);
    }
    protected function given_prefecture(){
        $this->prefecture = Prefecture::factory()->create([
            'country_id' => 1,
            'admin_id' => 1,
            'name' => 'Name',
            'status' => 1,
        ]);
    }
    protected function given_approved_male_user(){
        $mobileNumber = '0123456';
        $authId = Utility::encode($mobileNumber);

        $this->user = User::factory()->create([
            'status' => UserStatus::ApprovedUser,
            'gender' => UserGender::Male,
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

    protected function given_active_trial(){
            UserTrial::factory()->create([
            'user_id' => $this->user->id,
            'status' => TrialStatus::Active,
            'trial_start' => Carbon::now(),
            'trial_end' => Carbon::now()->addWeeks(2),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
    protected function given_temp_cancelled_trial(){
        UserTrial::factory()->create([
            'user_id' => $this->user->id,
            'status' => TrialStatus::TempCancelled,
            'trial_start' => Carbon::now(),
            'trial_end' => Carbon::now()->addWeeks(2),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
    protected function given_participant(){
            ParticipantMainMatch::factory()->create([
            'user_id' => $this->user->id,
            'dating_day_id' => $this->thisWednesday->id,
            'status' => ParticipantsStatus::Awaiting,
        ]);
    }

    protected function given_coupon()
    {
        $coupon = Coupon::factory()->create([
            'name' => 'dating',
            'coupon_type' => 'dating'
        ]);
        UserCoupon::factory()->create([
            'user_id' => $this->user->id,
            'coupon_id' => $coupon->id,
            'dating_day_id' => "",
            'status' => UserCouponStatus::Unused,
            'expiry_at' => \Illuminate\Support\Carbon::now()->addWeeks(3)
        ]);
    }
    protected function given_dating_place(){
        $this->datingPlace = DatingPlace::factory()->create([
            'area_id' => 1,
            'train_station_id' => 1,
            'category' => 'category',
            'latitude' => 1,
            'longitude' => 1,
            'rating' => 1,
            'display_phone' => '123',
            'phone' => '123',
            'reference_page_link' => 'http://link.com',
            'status' => 1,
            'image' => 'image'
        ]);
    }
    protected function given_participant_and_dating_this_week()
    {
        ParticipantMainMatch::factory()->create([
            'user_id' => $this->user->id,
            'dating_day_id' => $this->thisWednesday->id,
            'status' => ParticipantsStatus::Matched
        ]);

        $this->dating = Dating::factory()->create([
            'dating_day_id' => $this->thisWednesday->id,
            'dating_place_id' => $this->datingPlace->id,
            'status' => DatingStatus::Completed
        ]);
        DatingUser::factory()->create([
            'dating_id' => $this->dating->id,
            'user_id' => $this->user->id
        ]);
    }

    protected function given_participant_and_dating_last_week()
    {
        ParticipantMainMatch::factory()->create([
            'user_id' => $this->user->id,
            'dating_day_id' => $this->lastWednesday->id,
            'status' => ParticipantsStatus::Matched
        ]);
        $this->dating = Dating::factory()->create([
            'dating_day_id' => $this->lastWednesday->id,
            'dating_place_id' => $this->datingPlace->id,
            'status' => DatingStatus::Completed
        ]);
        DatingUser::factory()->create([
            'dating_id' => $this->dating->id,
            'user_id' => $this->user->id
        ]);
    }
}
