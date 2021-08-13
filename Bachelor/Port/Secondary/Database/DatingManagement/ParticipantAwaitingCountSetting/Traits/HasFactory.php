<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\Traits;


use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\Factory\ParticipantAwaitingCountSettingFactory;

trait HasFactory
{
    /**
     * Get a new factory instance for the model.
     *
     * @param  mixed  $parameters
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function factory(...$parameters)
    {
        return new ParticipantAwaitingCountSettingFactory();
    }
}
