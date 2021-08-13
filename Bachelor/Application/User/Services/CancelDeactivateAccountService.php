<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Domain\UserManagement\User\Enums\CancelDeactivateType;
use Bachelor\Domain\UserManagement\User\Events\SentCancellationForm;
use Bachelor\Domain\UserManagement\User\Events\SentDeactivationForm;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService ;

class CancelDeactivateAccountService
{

    protected UserDomainService $userDomainService;

    public function __construct(
        UserDomainService $userDomainService
    ) {
        $this->userDomainService = $userDomainService;
    }

    /**
     * Process cancel account
     *
     * @param User $user
     * @param $data
     * @return bool
     */
    public function processCancel(User $user, $data): bool
    {
        if ($this->userDomainService->cancelUserAccount($user)) {
            $this->userDomainService->createCancelDeactivateForm($user, $data, CancelDeactivateType::Cancel);
            SentCancellationForm::dispatch($user);

            return true;
        }

        return false;
    }

    /**
     * Process deactivate account
     *
     * @param User $user
     * @param $data
     * @return bool
     */
    public function processDeactivate(User $user, $data): bool
    {
        if ($this->userDomainService->deactivateUserAccount($user)) {
            $this->userDomainService->createCancelDeactivateForm($user, $data, CancelDeactivateType::Deactivate);
            SentDeactivationForm::dispatch($user);
            return true;
        }

        return false;

    }

    public function validateCancelDeactivateAccount(User $user): array
    {
        return $this->userDomainService->validateUserCanCancelDeactivateAccount($user, false);
    }
}
