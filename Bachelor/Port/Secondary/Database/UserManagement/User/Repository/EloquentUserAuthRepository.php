<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\User\Repository;

use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserAuthInterface;
use Bachelor\Utility\Enums\Status;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;

class EloquentUserAuthRepository extends EloquentBaseRepository implements EloquentUserAuthInterface
{
    /**
     * EloquentUserAuthRepository constructor.
     * @param UserAuth $model
     */
    public function __construct(UserAuth $model)
    {
        parent::__construct($model);
    }

    /**
     * Retrieve user auth
     *
     * @param string $authId
     * @param string $authColumn
     * @return Builder
     */
    public function retrieveUserAuthViaAuthIdQueryBuilder(string $authId, string $authColumn = 'auth_id'): Builder
    {
        return $this->model->with('user')->where($authColumn, $authId)->orderBy('id', 'desc');
    }

    /**
     * Used to create new auth user
     *
     * @param array $authData
     * @return UserAuth
     */
    public function createNewUserAuth(array $authData): UserAuth
    {
        return $this->model->create($authData);
    }

    /**
     * get by user id
     *
     * @param int $userId
     * @return UserAuth
     */
    public function getByUserId(int $userId): UserAuth
    {
        return $this->model->newModelQuery()->where('user_id', $userId)->first();
    }

    /**
     * Log when user login
     *
     * @param UserAuth $userAuth
     * @return mixed
     */
    public function logUserLogin(UserAuth $userAuth)
    {
        // Record user login time
        return $userAuth->user->userLogin()->updateOrCreate([
            'ip_address' => request()->ip()
        ]);
    }

    /**
     * Get base user data ( common for all type of users )
     *
     * @param UserAuth $userAuth
     * @return array
     */
    public function getUserDataAfterAuthentication(UserAuth $userAuth): array
    {
        return [
            'userAuth' => $userAuth,
            'needs_mobile_number_verification' => empty($userAuth->user->mobile_number),
            'user_prefecture_status' => $userAuth->user->prefecture()->first()?->status == Status::Active,
            'socialLoginLink' => $userAuth->getAutoLoginUrl()
        ];
    }
}
