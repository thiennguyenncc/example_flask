<?php


namespace Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces;

use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\Room;

interface EloquentRoomInterface
{
    /**
     * @param array $params
     * @return mixed
     */
    public function createRoom(array $params);

    /**
     * @param string $keyword
     * @param array $roomIds
     * @param null $perPage
     * @return mixed
     */
    public function getRooms($keyword = '', $roomIds = [], $perPage = null);

    /**
     * @param integer $id
     * @return array
     */
    public function getDaoBy(string $id): Room;
}
