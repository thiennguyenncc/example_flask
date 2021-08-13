<?php

namespace Bachelor\Application\User\Providers;

use Bachelor\Port\Secondary\Communication\Twilio\Interfaces\TwilioServiceInterface;
use Bachelor\Port\Secondary\Communication\Twilio\Repository\TwilioService;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentCursorInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentMessageInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentRoomInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentRoomUserInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\Repository\EloquentCursorRepository;
use Bachelor\Port\Secondary\Database\Communication\Chat\Repository\EloquentMessageRepository;
use Bachelor\Port\Secondary\Database\Communication\Chat\Repository\EloquentRoomRepository;
use Bachelor\Port\Secondary\Database\Communication\Chat\Repository\EloquentRoomUserRepository;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class CommunicationServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Repository
        $this->app->bind(TwilioServiceInterface::class, TwilioService::class);

        //@TODO: remove after DMR
        $this->app->bind(EloquentCursorInterface::class, EloquentCursorRepository::class);
        $this->app->bind(EloquentMessageInterface::class, EloquentMessageRepository::class);
        $this->app->bind(EloquentRoomInterface::class, EloquentRoomRepository::class);
        $this->app->bind(EloquentRoomUserInterface::class, EloquentRoomUserRepository::class);
    }
}
