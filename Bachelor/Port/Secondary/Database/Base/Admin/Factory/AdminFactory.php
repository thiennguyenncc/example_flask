<?php

namespace Bachelor\Port\Secondary\Database\Base\Admin\Factory;

use Illuminate\Database\Eloquent\Factories\Factory;
use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\Admin;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
