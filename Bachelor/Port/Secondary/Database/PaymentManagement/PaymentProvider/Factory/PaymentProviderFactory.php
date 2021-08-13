<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\PaymentProvider\Factory;

use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentProvider\ModelDao\PaymentProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentProvider::class;

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

