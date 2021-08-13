<?php

namespace Bachelor\Application\User\Providers;

use Bachelor\Application\User\Services\DatingApplicationService;
use Bachelor\Application\User\Services\Interfaces\DatingApplicationServiceInterface;
use Bachelor\Application\User\Services\Interfaces\MatchInfoApplicationServiceInterface;
use Bachelor\Application\User\Services\Interfaces\ParticipantForRematchServiceInterface;
use Bachelor\Application\User\Services\Interfaces\ParticipantMainMatchServiceInterface;
use Bachelor\Application\User\Services\UserMatchInfoService;
use Bachelor\Application\User\Services\ParticipantForRematchService;
use Bachelor\Application\User\Services\ParticipantMainMatchService;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Interfaces\ParticipantAwaitingCountSettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Interfaces\ParticipationOpenExpirySettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Interfaces\ParticipantAwaitingCancelSettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Interfaces\ParticipantForRematchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Interfaces\ParticipantRecommendationSettingRepositoryInterface;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\Repository\DatingRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\Repository\EloquentDatingDayRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\Repository\ParticipantAwaitingCountSettingRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipationOpenExpirySetting\Repository\EloquentParticipationOpenExpirySettingRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\Matching\Interfaces\EloquentMatchingSettingInterface;
use Bachelor\Port\Secondary\Database\DatingManagement\Matching\Repository\EloquentMatchingSettingRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCancelSetting\Repository\ParticipantAwaitingCancelSettingRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantForRematch\Repository\EloquentParticipantForRematch;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\Repository\EloquentParticipantMainMatchRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantRecommendationSetting\Repository\ParticipantRecommendationSettingRepository;
use Illuminate\Support\ServiceProvider;

class DatingServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Application
        $this->app->bind(DatingApplicationServiceInterface::class, DatingApplicationService::class);
        $this->app->bind(ParticipantMainMatchServiceInterface::class, ParticipantMainMatchService::class);

        // Repository
        $this->app->bind(ParticipantMainMatchRepositoryInterface::class, EloquentParticipantMainMatchRepository::class);
        $this->app->bind(ParticipantForRematchRepositoryInterface::class, EloquentParticipantForRematch::class);
        $this->app->bind(ParticipationOpenExpirySettingRepositoryInterface::class, EloquentParticipationOpenExpirySettingRepository::class);
        $this->app->bind(DatingDayRepositoryInterface::class, EloquentDatingDayRepository::class);
        $this->app->bind(DatingRepositoryInterface::class, DatingRepository::class);
        $this->app->bind(ParticipantRecommendationSettingRepositoryInterface::class, ParticipantRecommendationSettingRepository::class);
        $this->app->bind(ParticipantAwaitingCancelSettingRepositoryInterface::class, ParticipantAwaitingCancelSettingRepository::class);
        $this->app->bind(ParticipantAwaitingCountSettingRepositoryInterface::class, ParticipantAwaitingCountSettingRepository::class);

        //@TODO: remove after DMR
        $this->app->bind(EloquentMatchingSettingInterface::class, EloquentMatchingSettingRepository::class);
    }
}
