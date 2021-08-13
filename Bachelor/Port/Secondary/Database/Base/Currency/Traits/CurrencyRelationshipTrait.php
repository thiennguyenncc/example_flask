<?php

namespace Bachelor\Port\Secondary\Database\Base\Currency\Traits;

trait CurrencyRelationshipTrait
{
    /**
     * Get all countries utilizing this language
     *
     * @return mixed
     */
    public function countries()
    {
        return $this->hasMany(Country::class);
    }
}
