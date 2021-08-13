<?php

namespace Bachelor\Domain\UserManagement\User\Models;

use Bachelor\Domain\UserManagement\User\Traits\UserAccountMigrationTrait;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserAccountMigrationLogInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserAuthInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserMigration
{
    use UserAccountMigrationTrait;

    /**
     * @var UserAuth
     */
    private $authAccountToMigrateTo;

    /*
     * @var UserAuth
     */
    private $authAccountToMigrateFrom;

    /**
     * @var EloquentUserAccountMigrationLogInterface
     */
    private $userAccountMigrationLogRepository;

    /*
     * @var UserAuthRepositoryInterface
     */
    private $userAuthRepository;

    /**
     * @var string
     */
    private $authType;

    /**
     * UserMigration constructor.
     *
     * @param UserAuth $authAccountToMigrateTo
     * @param UserAuth $authAccountToMigrateFrom
     * @param string $authType
     * @throws BindingResolutionException
     */
    public function __construct (UserAuth $authAccountToMigrateTo, UserAuth $authAccountToMigrateFrom, string $authType)
    {
        $this->authAccountToMigrateTo = $authAccountToMigrateTo;
        $this->authAccountToMigrateFrom = $authAccountToMigrateFrom;
        $this->authType = $authType;
        $this->userAccountMigrationLogRepository = app()->make(EloquentUserAccountMigrationLogInterface::class);
        $this->userAuthRepository = app()->make(EloquentUserAuthInterface::class);
    }

    /**
     *  Log user account migration information
     * @return mixed
     */
    public function handleUserAccountMigrationLog () : UserMigration
    {
        $this->userAccountMigrationLogRepository->firstOrCreate([
            'user_id' => $this->authAccountToMigrateTo->user_id,
            'deactivated_user_id' => $this->authAccountToMigrateFrom->user_id,
            'mobile_number' => $this->authAccountToMigrateFrom->user->mobile_number,
        ], self::getUserAccountMigrationLogData());

        return $this;
    }

    /**
     * Migrate user account data
     *
     * @return string
     * @throws Exception
     */
    public function analyzeUserAccountForMigration() : string
    {
        // Migrate user data
        if(self::migrateUserData())
        {
            // Logout the user
            Auth::logout();

            // Nullify the user auth data to avoid user from logging in
            if(self::nullifyUserAuth())
            {
                DB::commit();

                // Redirect to social login for re-authentication with updated user account
                return env('WEB_APP_LOGIN_URL')."?authId=".$this->authAccountToMigrateTo->auth_id."&authType=".$this->authType."&newUser=&duplicateUser=";
            }

        }

        // Or else throw an exception
        throw new Exception(__('api_messages.problem_encountered_while_migrating_account'),
            [
                'migrating_to_user_id' => $this->authAccountToMigrateTo->user_id,
                'migrating_from_user_id' => $this->authAccountToMigrateFrom->user_id
            ]);
    }

    /**
     * Get all users from the collection
     *
     * @param Builder $data
     * @param string $columns
     * @return array|string|null
     */
    protected function getAllUserData(Builder $data, string $columns)
    {
        $dataArray = null;

        if(!empty($data->count()))
        {
            $dataArray = $data->select($columns)->get()->toArray();
            $dataArray = collect($dataArray)->flatten()->all();
            $dataArray = implode(',', $dataArray);
        }

        return $dataArray;
    }
}
