<?php


namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\Factory;


use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantMainMatchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ParticipantMainMatch::class;

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
