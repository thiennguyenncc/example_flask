<?php

namespace Bachelor\Port\Secondary\Database\Base\Language\Traits;

use Bachelor\Port\Secondary\Database\app\Http\Models\Country;

trait LanguageRelationshipTrait
{
    /**
     * Get all registration translation data
     *
     * @return mixed
     */
    public function registerOptionsTranslations()
    {
        return $this->hasMany(RegisterOptionTranslation::class);
    }

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
