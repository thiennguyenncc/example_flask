<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\Registration\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\Registration\ModelDao\RegisterOptionTranslation;
use Illuminate\Support\Facades\App;

trait RegisterOptionRelationshipTrait
{
    /**
     * Get the register option translations
     *
     * @return mixed
     */
    public function registerOptionsTranslations()
    {
        return $this->hasMany(RegisterOptionTranslation::class, 'register_option_id', 'id')
            ->whereHas('language', function ($query) {
                    $query->where('short_code', App::getLocale());
            });
    }
}
