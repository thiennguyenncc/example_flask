<?php


namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipationOpenExpirySetting\Traits;


use Bachelor\Port\Secondary\Database\DatingManagement\ParticipationOpenExpirySetting\ModelDao\ParticipationOpenExpirySetting;

Trait HasFactory
{
    public static function factory(...$parameters)
    {
        return new ParticipationOpenExpirySetting();
    }
}
