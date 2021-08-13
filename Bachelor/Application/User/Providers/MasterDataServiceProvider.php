<?php

namespace Bachelor\Application\User\Providers;

use Bachelor\Domain\MasterDataManagement\Area\Interfaces\AreaRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Coupon\Interfaces\CouponRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Prefecture\Interfaces\PrefectureRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Interfaces\ReviewBoxRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\ReviewPoint\Interfaces\ReviewPointRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\School\Interfaces\SchoolRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\TrainStation\Interfaces\TrainStationRepositoryInterface;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\Repository\EloquentAreaRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\Repository\CouponRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Repository\EloquentDatingPlaceRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\Repository\EloquentPrefectureRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewBox\Repository\ReviewBoxRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewPoint\Repository\ReviewPointRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\School\Repository\EloquentSchoolRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\Repository\EloquentTrainStationRepository;
use Illuminate\Support\ServiceProvider;

class MasterDataServiceProvider extends ServiceProvider
{
    public function register()
    {

        // Repository
        $this->app->bind(AreaRepositoryInterface::class, EloquentAreaRepository::class);
        $this->app->bind(DatingPlaceRepositoryInterface::class, EloquentDatingPlaceRepository::class);
        $this->app->bind(PrefectureRepositoryInterface::class, EloquentPrefectureRepository::class);
        $this->app->bind(ReviewPointRepositoryInterface::class, ReviewPointRepository::class);
        $this->app->bind(ReviewBoxRepositoryInterface::class, ReviewBoxRepository::class);
        $this->app->bind(CouponRepositoryInterface::class, CouponRepository::class);
        $this->app->bind(SchoolRepositoryInterface::class, EloquentSchoolRepository::class);
        $this->app->bind(TrainStationRepositoryInterface::class, EloquentTrainStationRepository::class);
    }
}
