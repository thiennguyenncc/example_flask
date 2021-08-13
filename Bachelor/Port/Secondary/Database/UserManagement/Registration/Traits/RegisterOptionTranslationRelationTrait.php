<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\Registration\Traits;

use Bachelor\Port\Secondary\Database\Base\Language\ModelDao\Language;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\ModelDao\RegisterOption;

trait RegisterOptionTranslationRelationTrait
{
    /**
     * Get the register option translations
     *
     * @return mixed
     */
    public function registerOptionsTranslations(): mixed
    {
        return $this->belongsTo(RegisterOption::class, 'register_option_id', 'id');
    }

    /**
     * Get the register option translations
     *
     * @return mixed
     */
    public function language(): mixed
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
