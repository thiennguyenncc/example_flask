<?php


namespace Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Traits;


use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Factory\DatingPlaceFactory;

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
        return new DatingPlaceFactory();
    }
}
