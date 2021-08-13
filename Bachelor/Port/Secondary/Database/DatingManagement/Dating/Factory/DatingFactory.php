<?php


namespace Bachelor\Port\Secondary\Database\DatingManagement\Dating\Factory;


use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Dating::class;

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
