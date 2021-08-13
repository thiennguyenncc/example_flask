<?php


namespace Bachelor\Application\User\Providers;

use Bachelor\Port\Secondary\Utility\FirebaseLinkHandlerRepository;
use Bachelor\Utility\Http\Interfaces\HttpClientInterface;
use Bachelor\Utility\Interfaces\LinkHandlerRepositoryInterface;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(HttpClientInterface::class, function($app) {
            return env('APP_ENV') === 'local' ? new Client([ 'verify' => false ]) : new Client();
        });
        $this->app->bind(LinkHandlerRepositoryInterface::class, FirebaseLinkHandlerRepository::class);
    }
}
