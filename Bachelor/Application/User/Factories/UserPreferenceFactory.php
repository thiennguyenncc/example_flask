<?php
namespace Bachelor\Application\User\Factories;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreference\ModelDao\UserPreference;

class UserPreferenceFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserPreference::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // We do not use random numbers for matching algorithm
        // So that users can match as per our criteria and not randomly
        return [
            'user_id' => User::factory(),
            'age_from' => $this->faker->numberBetween(20, 35),
            'age_to' => $this->faker->numberBetween(35, 50),
            'height_from' => $this->faker->numberBetween(140, 160),
            'height_to' => $this->faker->numberBetween(160, 200),
            'partner_body_min' => $this->faker->numberBetween(0, 3),
            'partner_body_max' => $this->faker->numberBetween(3, 4),
            'smoking' => $this->faker->numberBetween(0, 3),
            'drinking' => $this->faker->numberBetween(0, 2),
            'divorce' => $this->faker->numberBetween(0, 3),
            'annual_income' => $this->faker->numberBetween(1, 5),
            'education' => $this->faker->numberBetween(0, 2),
            'job' => $this->faker->randomElement([
                1,
                2,
                3,
                4,
                5,
                6,
                7,
                8
            ]),
            'face_preferences' => $this->randomFacePreferences(),
            'appearance_priority' => $this->faker->numberBetween(1, 3),
            'first_priority' => $this->faker->numberBetween(- 1, 12),
            'second_priority' => $this->faker->numberBetween(- 1, 12),
            'third_priority' => $this->faker->numberBetween(- 1, 12),
            'hobby' => $this->faker->numberBetween(1, 26)
        ];
    }

    /**
     * Returns random face preferences
     * 
     * @return string
     */
    private function randomFacePreferences(array $params = [
        'st_00',
        'st_01',
        'st_02',
        'st_03',
        'st_04',
        'st_05',
        'st_06',
        'st_07',
        'st_08',
        'st_09',
        'st_10',
        'fe_00',
        'fe_01',
        'fe_02',
        'fe_03',
        'fe_04',
        'fe_05',
        'fe_06',
        'fe_07',
        'fe_08',
        'fe_09',
        'fe_10',
        'fe_11'
    ])
    {
        return implode(",", $this->faker->randomElements($params, $this->faker->numberBetween(1, count($params))));
    }

    /**
     * Preference template1 without randomized data for unit tests
     *
     * @return \Bachelor\Application\User\Factories\UserPreferenceFactory
     */
    public function preference1()
    {
        return $this->state(function (array $attributes) {
            return [
                'age_from' => 20,
                'age_to' => 35,
                'height_from' => 140,
                'height_to' => 160,
                'partner_body_min' => 0,
                'partner_body_max' => 3,
                'smoking' => 0,
                'drinking' => 0,
                'divorce' => 0,
                'annual_income' => 1,
                'education' => 0,
                'job' => 1,
                'face_preferences' => 'st_00,st_01,st_02,st_03,st_04,fe_00,fe_01,fe_02',
                'appearance_priority' => 1,
                'first_priority' => 1,
                'second_priority' => 1,
                'third_priority' => 1,
                'hobby' => 1
            ];
        });
    }
}
