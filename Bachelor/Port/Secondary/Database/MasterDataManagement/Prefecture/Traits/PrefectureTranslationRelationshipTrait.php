<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\Traits;

use Bachelor\Port\Secondary\Database\Base\Language\ModelDao\Language;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;

trait PrefectureTranslationRelationshipTrait
{
    /**
     * Get the prefecture to which it belongs to
     *
     * @return mixed
     */
    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
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
