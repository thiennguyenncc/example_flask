<?php


namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\Traits;


use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\Factory\ParticipantMainMatchFactory;

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
        return new ParticipantMainMatchFactory();
    }
}
