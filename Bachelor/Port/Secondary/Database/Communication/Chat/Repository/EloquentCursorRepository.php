<?php


namespace Bachelor\Port\Secondary\Database\Communication\Chat\Repository;


use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentCursorInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\Cursor;

class EloquentCursorRepository extends EloquentBaseRepository implements EloquentCursorInterface
{
    public function __construct(Cursor $cursor)
    {
        parent::__construct($cursor);
    }
}
