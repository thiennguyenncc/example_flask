<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\School\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait SchoolRelationshipTrait
{
    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
