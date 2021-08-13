<?php

namespace Bachelor\Application\User\Providers;

use Bachelor\Port\Secondary\Database\Base\Country\Interfaces\EloquentCountryInterface;
use Bachelor\Port\Secondary\Database\Base\Country\Repository\EloquentCountryRepository;
use Bachelor\Port\Secondary\Database\Base\Currency\Interfaces\EloquentCurrencyInterface;
use Bachelor\Port\Secondary\Database\Base\Currency\Repository\EloquentCurrencyRepository;
use Bachelor\Port\Secondary\Database\Base\Language\Interfaces\EloquentLanguageInterface;
use Bachelor\Port\Secondary\Database\Base\Language\Repository\EloquentLanguageRepository;
use Bachelor\Port\Secondary\Database\Base\SystemDate\Interfaces\EloquentSystemDateInterface;
use Bachelor\Port\Secondary\Database\Base\SystemDate\Repository\EloquentSystemDateRepository;
use Bachelor\Port\Secondary\Database\Base\TimeSetting\Interfaces\EloquentTimeSettingInterface;
use Bachelor\Port\Secondary\Database\Base\TimeSetting\Repository\EloquentTimeSettingRepository;
use Illuminate\Support\ServiceProvider;

class BaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        //@TODO: remove after DMR
        $this->app->bind(EloquentTimeSettingInterface::class, EloquentTimeSettingRepository::class);
        $this->app->bind(EloquentSystemDateInterface::class, EloquentSystemDateRepository::class);
        $this->app->bind(EloquentCountryInterface::class, EloquentCountryRepository::class);
        $this->app->bind(EloquentCurrencyInterface::class, EloquentCurrencyRepository::class);
        $this->app->bind(EloquentLanguageInterface::class, EloquentLanguageRepository::class);
    }
}
