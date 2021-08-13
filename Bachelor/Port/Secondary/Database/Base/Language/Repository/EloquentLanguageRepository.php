<?php

namespace Bachelor\Port\Secondary\Database\Base\Language\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Base\Language\Interfaces\EloquentLanguageInterface;
use Bachelor\Port\Secondary\Database\Base\Language\ModelDao\Language;

class EloquentLanguageRepository extends EloquentBaseRepository implements EloquentLanguageInterface
{
    /**
     * EloquentLanguageRepository constructor.
     * @param Language $model
     */
    public function __construct(Language $model)
    {
        parent::__construct($model);
    }
}
