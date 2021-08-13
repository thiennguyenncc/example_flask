<?php

namespace Bachelor\Application\User\EventHandler\Listeners\UserTrial;

use Bachelor\Domain\UserManagement\User\Events\CompletedTrial;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Support\Facades\Http;

class SendAffiliateConversion
{
    public function __construct(){

    }

    /**
     * @param CompletedTrial $event
     * @return void
     */
    public function handle(CompletedTrial $event)
    {
        $user = $event->user;
        $url = $user->getUrlForAfiB('g1225n');
        if ($url) {
            Http::get($url);
            Log::info('Send result to the affiliate company with first paid user. UserId: ' . $user->getId());

            return;
        }

        Log::info('Affiliate company url not found!');
    }
}
