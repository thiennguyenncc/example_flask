<?php

namespace Bachelor\Application\Admin\Providers;

use Bachelor\Application\Admin\Services\AdminChatService;
use Bachelor\Application\Admin\Services\AdminCouponService;
use Bachelor\Application\Admin\Services\AdminDatingService;
use Bachelor\Application\Admin\Services\ParticipantAwaitingCountSettingService;
use Bachelor\Application\Admin\Services\AdminNotificationService;
use Bachelor\Application\Admin\Services\AdminSchoolService;
use Bachelor\Application\Admin\Services\AdminService;
use Bachelor\Application\Admin\Services\AdminSettingService;
use Bachelor\Application\Admin\Services\AdminTimeSettingService;
use Bachelor\Application\Admin\Services\Interfaces\AdminChatServiceInterface;
use Bachelor\Application\Admin\Services\Interfaces\AdminCouponServiceInterface;
use Bachelor\Application\Admin\Services\Interfaces\AdminDatingServiceInterface;
use Bachelor\Application\Admin\Services\Interfaces\ParticipantAwaitingCountSettingServiceInterface;
use Bachelor\Application\Admin\Services\Interfaces\AdminNotificationServiceInterface;
use Bachelor\Application\Admin\Services\Interfaces\AdminSchoolServiceInterface;
use Bachelor\Application\Admin\Services\Interfaces\AdminServiceInterface;
use Bachelor\Application\Admin\Services\Interfaces\AdminSettingServiceInterface;
use Bachelor\Application\Admin\Services\Interfaces\AdminTimeSettingServiceInterface;
use Bachelor\Domain\Base\Admin\Services\AdminRepository;
use Bachelor\Domain\Base\Admin\Services\Interfaces\AdminInterface;
use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Interfaces\MatchInfoGroupInterface;
use Bachelor\Port\Secondary\Database\Base\Admin\Interfaces\EloquentAdminActionLogInterface;
use Bachelor\Port\Secondary\Database\Base\Admin\Interfaces\EloquentAdminInterface;
use Bachelor\Port\Secondary\Database\Base\Admin\Repository\EloquentAdminActionLogRepository;
use Bachelor\Port\Secondary\Database\Base\Admin\Repository\EloquentAdminRepository;
use Bachelor\Port\Secondary\Database\Base\SystemDate\Interfaces\EloquentSystemDateInterface;
use Bachelor\Port\Secondary\Database\Base\SystemDate\Repository\EloquentSystemDateRepository;
use Bachelor\Port\Secondary\Database\Base\TimeSetting\Interfaces\EloquentTimeSettingInterface;
use Bachelor\Port\Secondary\Database\Base\TimeSetting\Repository\EloquentTimeSettingRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\MatchInfo\Repository\EloquentMatchInfoGroupRepository;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AdminServiceInterface::class, AdminService::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);
        $this->app->bind(AdminCouponServiceInterface::class, AdminCouponService::class);
        $this->app->bind(AdminDatingServiceInterface::class, AdminDatingService::class);
        $this->app->bind(AdminSettingServiceInterface::class, AdminSettingService::class);
        $this->app->bind(AdminNotificationServiceInterface::class, AdminNotificationService::class);
        $this->app->bind(ParticipantAwaitingCountSettingServiceInterface::class, ParticipantAwaitingCountSettingService::class);
        $this->app->bind(AdminTimeSettingServiceInterface::class, AdminTimeSettingService::class);
        $this->app->bind(AdminSchoolServiceInterface::class, AdminSchoolService::class);
        $this->app->bind(AdminChatServiceInterface::class, AdminChatService::class);

        //@TODO: deprecated parts: remove after DMR refactoring
        $this->app->bind(EloquentAdminInterface::class, EloquentAdminRepository::class);
        $this->app->bind(EloquentAdminActionLogInterface::class, EloquentAdminActionLogRepository::class);
        $this->app->bind(EloquentTimeSettingInterface::class, EloquentTimeSettingRepository::class);
        $this->app->bind(EloquentSystemDateInterface::class, EloquentSystemDateRepository::class);
        $this->app->bind(MatchInfoGroupInterface::class, EloquentMatchInfoGroupRepository::class);
    }
}
