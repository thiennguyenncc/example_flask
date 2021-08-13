<?php


namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\Factory;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\ModelDao\ParticipantAwaitingCountSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParticipantAwaitingCountSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ParticipantAwaitingCountSetting::class;

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
