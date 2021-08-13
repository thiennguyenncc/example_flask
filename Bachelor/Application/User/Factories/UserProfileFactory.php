<?php
namespace Bachelor\Application\User\Factories;

use Bachelor\Port\Secondary\Database\MasterDataManagement\School\ModelDao\School;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

class UserProfileFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'birthday' => $this->faker->dateTimeBetween('-50 years','-20 years'),
            'height' => $this->faker->numberBetween(100, 200),
            'body_type' => $this->faker->numberBetween(1, 5),
            'marriage_intention' => $this->faker->numberBetween(1, 3),
            'character' => $this->randomizeCharacters(),
            'smoking' => $this->faker->numberBetween(1, 5),
            'drinking' => $this->faker->numberBetween(1, 3),
            'divorce' => $this->faker->numberBetween(1, 2),
            'annual_income' => $this->faker->numberBetween(1, 7),
            'appearance_strength' => $this->randomizeElements([
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
                'st_10'
            ]),
            'appearance_features' => $this->randomizeElements([
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
            ]),
            'school_id' => School::factory(),
            'education' => $this->faker->numberBetween(1, 4),
            'company_name' => $this->faker->company,
            'job' => $this->faker->numberBetween(0, 45),
            'hobby' => $this->randomizeHobbies()
        ];
    }

    /**
     * Randomize elements
     *
     * @param array $params
     * @return string
     */
    private function randomizeElements(array $params)
    {
        return implode(",", $this->faker->randomElements($params, $this->faker->numberBetween(1, count($params))));
    }

    /**
     * Randomizes character attributes
     *
     * @return string
     */
    private function randomizeCharacters()
    {
        $characters = [];
        for ($i = 0; $i < $this->faker->numberBetween(1, 21); $i ++) {

            $characters[] = $this->faker->numberBetween(1, 21);
        }

        return implode(',', $characters);
    }

    /**
     * Randomizes hobby attributes
     *
     * @return string
     */
    private function randomizeHobbies()
    {
        $hobbies = [];
        for ($i = 0; $i < $this->faker->numberBetween(1, 26); $i ++) {
            // get a random digit, but always a new one, to avoid duplicates
            $hobbies[] = $this->faker->numberBetween(1, 26);
        }

        return implode(',', $hobbies);
    }

    /**
     * Profile template1 without randomized data for unit tests
     *
     * @return \Bachelor\Application\User\Factories\UserProfileFactory
     */
    public function profile1()
    {
        return $this->state(function (array $attributes) {
            return [
                'birthday' => '1989-01-01',
                'height' => 10,
                'body_type' => 1,
                'marriage_intention' => 1,
                'character' => '1,2,3',
                'smoking' => 1,
                'drinking' => 1,
                'divorce' => 1,
                'annual_income' => 1,
                'appearance_strength' => 'st_00,st_01,st_02,st_03',
                'appearance_features' => 'fe_00,fe_01,fe_02',
                'education' => 1,
                'company_name' => $this->faker->company,
                'job' => 1,
                'hobby' => 1
            ];
        });
    }
}
