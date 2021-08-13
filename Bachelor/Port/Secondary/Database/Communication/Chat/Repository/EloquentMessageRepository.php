<?php


namespace Bachelor\Port\Secondary\Database\Communication\Chat\Repository;


use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentMessageInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\Message;

class EloquentMessageRepository extends EloquentBaseRepository implements EloquentMessageInterface
{
    /**
     * EloquentMessageRepository constructor.
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        parent::__construct($message);
    }
}
