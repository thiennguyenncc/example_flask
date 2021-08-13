<?php


namespace Bachelor\Application\Admin\Factories;


use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;

class DatingDayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DatingDay::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

        ];
    }
}
