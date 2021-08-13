<?php


namespace Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Factory;


use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatingPlaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DatingPlace::class;

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
