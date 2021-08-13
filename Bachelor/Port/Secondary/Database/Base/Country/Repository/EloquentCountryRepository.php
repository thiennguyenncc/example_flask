<?php

namespace Bachelor\Port\Secondary\Database\Base\Country\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Base\Country\Interfaces\EloquentCountryInterface;
use Bachelor\Port\Secondary\Database\Base\Country\ModelDao\Country;

class EloquentCountryRepository extends EloquentBaseRepository implements EloquentCountryInterface
{
    /**
     * EloquentCountryRepository constructor.
     * @param Country $model
     */
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }
}
