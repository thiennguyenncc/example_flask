<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\Factory;

use Bachelor\Application\User\Factories\Factory;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\ModelDao\UserTrial;
use Carbon\Carbon;

class UserTrialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserTrial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition () : array
    {
        return [];
    }

}
