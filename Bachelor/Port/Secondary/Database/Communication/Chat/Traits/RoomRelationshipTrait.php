<?php


namespace Bachelor\Port\Secondary\Database\Communication\Chat\Traits;


use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\Message;
use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\RoomUser;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait RoomRelationshipTrait
{
    /**
     * @return HasMany
     */
    public function roomUsers(): HasMany
    {
        return $this->hasMany(RoomUser::class, 'room_id');
    }

    /**
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'room_users');
    }

    /**
     * @return hasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'room_id');
    }

}
