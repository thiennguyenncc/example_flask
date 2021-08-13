<?php

namespace Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount;

use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Events\CancelledAccount;
use Bachelor\Domain\UserManagement\User\Events\DeactivatedAccount;
use Bachelor\Domain\UserManagement\User\Models\User;

class TempCancelTrialIfValid
{
    /**
     * @var UserTrialService
     */
    protected UserTrialService $userTrialService;


    public function __construct(
        UserTrialService $userTrialService
    ) {
        $this->userTrialService = $userTrialService;
    }

    public function handle(DeactivatedAccount|CancelledAccount $event)
    {
        /** @var User $user */
        $user = $event->user;

        $this->userTrialService->tempCancelIfValid($user);
    }
}
