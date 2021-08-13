<?php


namespace Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\Traits;



use Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\Factory\UserInfoUpdatedTimeFactory;

trait HasFactory
{
    public static function factory(...$parameters)
    {
        return new UserInfoUpdatedTimeFactory();
    }
}
