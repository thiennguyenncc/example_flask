<?php

namespace Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces;

interface EloquentRoomUserInterface
{
    /**
     * get list room id by user key search
     *
     * @param $filter
     * @return array
     */
    public function filterRoomId($filter);
}
