<?php

namespace Bachelor\Application\User\Factories;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Support\Str;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;

class UserFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mobile_number' => mt_rand(1000000000, 9999999999),
        ];
    }

    /**
     * Randomizes user data
     *
     * @return UserFactory
     *
     * @return UserFactory
     */
    public function random()
    {
        return $this->state(function (array $attributes) {
            return [
                'gender' => $this->faker->randomElement([UserGender::Male, UserGender::Female]),
                'prefecture_id' => $this->faker->randomElement([1, 2, 3]),
                'team_member_rate' => rand(1, 10),
            ];
        });
    }

    /**
     * Indicates the user is male
     *
     * @return UserFactory
     */
    public function male()
    {
        return $this->state(function (array $attributes) {
            return [
                'gender' => UserGender::Male
            ];
        });
    }

    /**
     * Indicates the user is female
     *
     * @return UserFactory
     */
    public function female()
    {
        return $this->state(function (array $attributes) {
            return [
                'gender' => UserGender::Female
            ];
        });
    }

    /**
     * Indicate that the user is fake female.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function fakeFemale()
    {
        return $this->state(function (array $attributes) {
            return [
                'gender' => UserGender::Female,
                'is_fake' => 1
            ];
        });
    }

    /**
     * Indicate that the user is incomplete status.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function incomplete()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => UserStatus::IncompleteUser
            ];
        });
    }

    /**
     * Indicate that the user is awaiting status.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function awaiting()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => UserStatus::AwaitingUser
            ];
        });
    }

    /**
     * Indicate that the user is verified status.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function verified()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => UserStatus::VerifiedUser
            ];
        });
    }

    /**
     * Indicate that the user is deactivated status.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function deactivated()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => UserStatus::DeactivatedUser
            ];
        });
    }

    /**
     * Indicate that the user is cancelled status.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function cancelled()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => UserStatus::CancelledUser
            ];
        });
    }

    /**
     * Indicate that the user has light cost plan
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function lightPlan()
    {
        return $this->state(function (array $attributes) {
            return [
                'cost_plan' => CostPlan::Light
            ];
        });
    }

    /**
     * Indicate that the user has premium cost plan
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function premiumPlan()
    {
        return $this->state(function (array $attributes) {
            return [
                'cost_plan' => CostPlan::Premium
            ];
        });
    }
}
