<?php

namespace Bachelor\Application\User\EventHandler\Listeners\ParticipantMainMatch;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\ParticipantMainMatchCreated;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Support\Facades\Http;

class SendAffiliateConversion
{

    /**
     * @param ParticipantMainMatchCreated $event
     * @return void
     */
    public function handle(ParticipantMainMatchCreated $event)
    {
        $user = $event->getParticipant()->getUser();
        if ($user->getStatus() >= UserStatus::ApprovedUser) return;

        $url = $user->getGender() == UserGender::Male ? $user->getUrlForAfiB() : $user->getUrlForAfiB('G1178U');

        if ($url) {
            Http::get($url);
            Log::info('Send result to the affiliate company with first participation completed. UserId: ' . $user->getId());

            return;
        }

        Log::info('Affiliate company url not found!');
    }
}
