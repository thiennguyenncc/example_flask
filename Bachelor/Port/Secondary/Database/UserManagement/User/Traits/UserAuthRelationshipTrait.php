<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\User\Traits;

use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User as UserDAO;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\OauthAccessToken;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserAuthRelationshipTrait
{
    /**
     * Anti-pattern but might work in this case
     *
     * @return User
     */
    public function getDomainEntity()
    {
        if (!$this->user) {
            $this->user = $this->user()->first()->toDomainEntity();
        }
        return $this->user;
    }

    /**
     * @deprecated
     *
     * @return BelongsTo | UserDAO
     */
    public function user()
    {
        return $this->belongsTo(UserDAO::class);
    }

    /**
     * Get user's oauth access token
     *
     * @return HasMany
     */
    public function oauthAccessToken()
    {
        return $this->hasMany(OauthAccessToken::class, 'user_id');
    }
}
