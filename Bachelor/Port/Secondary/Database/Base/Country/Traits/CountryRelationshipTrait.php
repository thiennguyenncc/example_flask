<?php

namespace Bachelor\Port\Secondary\Database\Base\Country\Traits;

use Bachelor\Port\Secondary\Database\Base\Currency\ModelDao\Currency;
use Bachelor\Port\Secondary\Database\Base\Language\ModelDao\Language;

trait CountryRelationshipTrait
{
    /**
     * Get currency data
     *
     * @return mixed
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get language data
     *
     * @return mixed
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
