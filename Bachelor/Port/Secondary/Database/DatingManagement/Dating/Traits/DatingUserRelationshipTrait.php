<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Dating\Traits;

use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUserCancellForm;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait DatingUserRelationshipTrait
{
    /**
     * @return BelongsTo
     */
    public function dating()
    {
        return $this->belongsTo(Dating::class);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     *  Get partner details
     */
    public function partner()
    {
        return DatingUser::where('dating_id', $this->dating_id)
            ->where('user_id', '!=', $this->user_id);
    }

    /**
     *  Get partner details
     */
    public function datingUserCancellForm()
    {
        return $this->hasOne(DatingUserCancellForm::class);
    }
}
