<?php


namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\Factories;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrefectureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prefecture::class;

    public function definition()
    {
        return [];
    }
}
