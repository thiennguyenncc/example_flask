<?php


namespace Bachelor\Port\Secondary\Database\DatingManagement\Dating\Traits;


use Bachelor\Port\Secondary\Database\DatingManagement\Dating\Factory\DatingFactory;

trait HasFactory
{
    /**
     * Get a new factory instance for the model.
     *
     * @param mixed $parameters
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function factory(...$parameters)
    {
        return new DatingFactory();
    }
}
