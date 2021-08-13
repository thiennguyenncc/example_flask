<?php

namespace Bachelor\Port\Secondary\Database\Base\Currency\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\Base\Currency\ModelDao\Currency;
use Bachelor\Port\Secondary\Database\Base\Currency\Interfaces\EloquentCurrencyInterface;

class EloquentCurrencyRepository extends EloquentBaseRepository implements EloquentCurrencyInterface
{
    /**
     * EloquentCurrencyRepository constructor.
     * @param Currency $model
     */
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }

}
