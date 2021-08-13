<?php


namespace Bachelor\Port\Secondary\Database\DatingManagement\Dating\Factory;


use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatingUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DatingUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }
}
