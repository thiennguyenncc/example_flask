<?php


namespace Bachelor\Port\Secondary\Database\UserManagement\UserProfile\Traits;


use Bachelor\Application\Admin\Factories\UserProfileFactory;

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
        return UserProfileFactory::factoryForModel(get_called_class())
            ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : null)
            ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }
}
