<?php
namespace Bachelor\Application\User\EventHandler\Listeners\ParticipantForRematch;

use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Events\ParticipantForRematchCancelled;
use Illuminate\Support\Facades\Log;

class TempCancelTrialIfValid
{

    /**
     * @var UserTrialService
     */
    private UserTrialService $userTrialService;

    public function __construct(UserTrialService $userTrialService)
    {
        $this->userTrialService = $userTrialService;
    }

    /**
     * @param ParticipantForRematchCancelled $event
     */
    public function handle(ParticipantForRematchCancelled $event)
    {
        $user = $event->getUser();

        try {
            $this->userTrialService->tempCancelIfValid($user);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
