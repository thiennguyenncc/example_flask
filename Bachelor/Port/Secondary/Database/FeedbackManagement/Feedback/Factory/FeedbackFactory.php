<?php


namespace Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Factory;


use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao\Feedback;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feedback::class;

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
