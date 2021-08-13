<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\Factory;

use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\ModelDao\PaymentCard;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentCardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentCard::class;

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

