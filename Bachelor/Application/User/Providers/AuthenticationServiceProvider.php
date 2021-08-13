<?php

namespace Bachelor\Application\User\Providers;

use Bachelor\Application\User\Services\AuthenticationService;
use Bachelor\Application\User\Services\Interfaces\AuthenticationServiceInterface;
use Bachelor\Port\Secondary\AuthenticationManagement\Facebook\Interfaces\FacebookApiInterface;
use Bachelor\Port\Secondary\AuthenticationManagement\Facebook\Repository\FacebookApi;
use Bachelor\Port\Secondary\AuthenticationManagement\Line\Interfaces\LineApiInterface;
use Bachelor\Port\Secondary\AuthenticationManagement\Line\Interfaces\LineRequestInterface;
use Bachelor\Port\Secondary\AuthenticationManagement\Line\Repository\LineApi;
use Bachelor\Port\Secondary\AuthenticationManagement\Line\Repository\LineRequest;
use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(AuthenticationServiceInterface::class, AuthenticationService::class);

        $this->app->bind(FacebookApiInterface::class, FacebookApi::class);
        $this->app->bind(LineApiInterface::class, LineApi::class);
        $this->app->bind(LineRequestInterface::class, LineRequest::class);
    }
}
