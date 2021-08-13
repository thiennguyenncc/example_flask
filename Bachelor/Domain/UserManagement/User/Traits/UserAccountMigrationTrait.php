<?php

namespace Bachelor\Domain\UserManagement\User\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;

trait UserAccountMigrationTrait
{
    /**
     * Get duplicate user account migration log
     *
     * @return array
     */
    protected function getUserAccountMigrationLogData() : array
    {
        return [
            'email' => $this->authAccountToMigrateTo->user->email,
            'deactivated_email' => $this->authAccountToMigrateFrom->user->email,
            'auth_type' => $this->authAccountToMigrateTo->auth_type,
            'deactivated_auth_type' => $this->authAccountToMigrateFrom->auth_type,
            'participation_ids' => null,
            'dating_ids' => null,
            'user_ids' => self::getAllUserData(
                $this->userAuthRepository->retrieveUserAuthViaAuthIdQueryBuilder($this->authAccountToMigrateFrom->auth_id),
                'user_id'
            )
        ];
    }

    /**
     *  Migrate user data
     *
     *  @return bool
     */
    protected function migrateUserData() :bool
    {
        return $this->authAccountToMigrateTo->user()->update(self::getUserDataForMigration($this->authAccountToMigrateFrom))
            && $this->authAccountToMigrateTo->update(self::getUserAuthDataForMigration($this->authAccountToMigrateFrom));
    }

    /**
     *  Nullify migrated user account data
     */
    protected function nullifyUserAuth()
    {
        return $this->authAccountToMigrateTo->user()->update([
                'mobile_number' => null
            ])
            && $this->authAccountToMigrateTo->update([
                'auth_type' => null
            ]);
    }

    /**
     * Get user data for migration
     *
     * @param UserAuth $authAccountToMigrateFrom
     * @return array
     */
    protected function getUserDataForMigration(UserAuth $authAccountToMigrateFrom)
    {
        return [
            'mobile_number' => $authAccountToMigrateFrom->user->mobile_number
        ];
    }

    /**
     * Get User Auth data for migration
     *
     * @param UserAuth $authAccountToMigrateFrom
     * @return array
     */
    protected function getUserAuthDataForMigration(UserAuth $authAccountToMigrateFrom)
    {
        return [
            'auth_id' => $authAccountToMigrateFrom->auth_id
        ];
    }

}
