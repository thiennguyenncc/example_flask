<?php


namespace Bachelor\Port\Secondary\Database\Communication\Chat\Repository;


use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentRoomUserInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\RoomUser;

class EloquentRoomUserRepository extends EloquentBaseRepository implements EloquentRoomUserInterface
{
    /**
     * EloquentRoomUserRepository constructor.
     * @param RoomUser $roomUser
     */
    public function __construct(RoomUser $roomUser)
    {
        parent::__construct($roomUser);
    }

    /**
     * get list room id by user key search
     *
     * @param $filter
     * @return array
     */
    public function filterRoomId($filter) {
        return $this->createQuery()->whereHas('user', function ($query) use ($filter) {
            $query->where('name', 'like', "%$filter%")
                ->orwhere('id', $filter);
        })->pluck('room_id')->toArray();
    }
}
