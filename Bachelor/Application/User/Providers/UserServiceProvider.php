<?php

namespace Bachelor\Application\User\Providers;

use Bachelor\Application\User\Services\Interfaces\UserCouponApplicationServiceInterface;
use Bachelor\Application\User\Services\UserCouponApplicationService;
use Bachelor\Application\User\Services\UserRegistrationService;
use Bachelor\Domain\UserManagement\User\Interfaces\SendableEmailRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Domain\UserManagement\UserInvitation\Interfaces\UserInvitationInterface;
use Bachelor\Domain\UserManagement\UserPreference\Interfaces\UserPreferenceInterface;
use Bachelor\Domain\UserManagement\UserPreferredArea\Interfaces\UserPreferredAreasInterface;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserImageInterface;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;
use Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Interfaces\UserInfoUpdatedTimeInterface;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Interfaces\EloquentRegisterOptionInterface;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Repository\EloquentRegisterOptionRepository;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentCancelDeactivateFormInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserAccountMigrationLogInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserActionLogInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserAuthInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\Repository\EloquentCancelDeactivateFormRepository;
use Bachelor\Port\Secondary\Database\UserManagement\User\Repository\EloquentUserAccountMigrationLogRepository;
use Bachelor\Port\Secondary\Database\UserManagement\User\Repository\EloquentUserActionLogRepository;
use Bachelor\Port\Secondary\Database\UserManagement\User\Repository\EloquentUserAuthRepository;
use Bachelor\Port\Secondary\Database\UserManagement\User\Repository\UserRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\Repository\UserCouponRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserInvitation\Repository\UserInvitationRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreference\Repository\UserPreferenceRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreferredArea\Repository\EloquentUserPreferredArea;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\Repository\UserImageRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\Repository\UserProfileRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\Repository\UserInfoUpdatedTimeRepository;
use Bachelor\Port\Secondary\UserManagement\Kickbox\Repository\KickboxSendableEmail;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Application
        $this->app->bind(UserCouponApplicationServiceInterface::class, UserCouponApplicationService::class);

        // Repository
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserCouponRepositoryInterface::class, UserCouponRepository::class);
        $this->app->bind(UserPreferredAreasInterface::class, EloquentUserPreferredArea::class);
        $this->app->bind(UserPreferenceInterface::class, UserPreferenceRepository::class);
        $this->app->bind(UserProfileInterface::class, UserProfileRepository::class);
        $this->app->bind(UserInfoUpdatedTimeInterface::class, UserInfoUpdatedTimeRepository::class);
        $this->app->bind(UserInvitationInterface::class, UserInvitationRepository::class);
        $this->app->bind(UserImageInterface::class, UserImageRepository::class);
        $this->app->bind(SendableEmailRepositoryInterface::class, KickboxSendableEmail::class);

        //@TODO: remove after DMR
        $this->app->bind(EloquentRegisterOptionInterface::class, EloquentRegisterOptionRepository::class);
        $this->app->bind(EloquentCancelDeactivateFormInterface::class, EloquentCancelDeactivateFormRepository::class);
        $this->app->bind(EloquentUserActionLogInterface::class, EloquentUserActionLogRepository::class);
        $this->app->bind(EloquentUserAccountMigrationLogInterface::class, EloquentUserAccountMigrationLogRepository::class);
        $this->app->bind(EloquentUserAuthInterface::class, EloquentUserAuthRepository::class);
    }
}
