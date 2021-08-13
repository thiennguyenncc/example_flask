<?php

namespace Bachelor\Application\User\EventHandler\Listeners\Registration;


use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\Registration\Events\GottenStepZeroData;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Support\Facades\Http;

class SendAffiliateConversion
{

    /**
     * @param GottenStepZeroData $event
     * @return void
     */
    public function handle(GottenStepZeroData $event)
    {
        $user = $event->user;
        if ($user->getStatus() >= UserStatus::ApprovedUser) {
            return;
        }
        $url = $user->getUrlForXApi();

        if ($url) {
            Http::get($url);
            Log::info('Send result to the affiliate company when user go to page 1 of the registration form. UserId: ' . $user->getId());

            return;
        }

        Log::info('Affiliate company url not found!');
    }
}
