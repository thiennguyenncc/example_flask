<?php


namespace Bachelor\Application\Admin\Factories;


use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;

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
        return [];
    }
}
