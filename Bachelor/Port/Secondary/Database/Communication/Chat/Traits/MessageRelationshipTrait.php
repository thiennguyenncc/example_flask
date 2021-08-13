<?php


namespace Bachelor\Port\Secondary\Database\Communication\Chat\Traits;


use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

trait MessageRelationshipTrait
{
    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
