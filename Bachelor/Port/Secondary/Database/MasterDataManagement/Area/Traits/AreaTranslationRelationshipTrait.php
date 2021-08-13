<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Area\Traits;

use Bachelor\Port\Secondary\Database\Base\Language\ModelDao\Language;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao\Area;

trait AreaTranslationRelationshipTrait
{
    /**
     * Get the area to which it belongs to
     *
     * @return mixed
     */
    public function area()
    {
        return $this->belongsTo(Area::class);
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
