<?php

namespace Bachelor\Application\User\EventHandler\Listeners\Dating;

use Bachelor\Domain\DatingManagement\Dating\Event\CancelledByPartner;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Models\User;

class TempCancelTrialIfValid
{
    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @var NotificationRepositoryInterface
     */
    protected NotificationRepositoryInterface $notificationRepository;

    /**
     * @var UserTrialRepositoryInterface
     */
    protected UserTrialRepositoryInterface $userTrialRepository;

    /**
     * @var UserTrialService
     */
    protected UserTrialService $userTrialService;

    /**
     * CancelRematchingOneMoreTrialNotification constructor.
     * @param NotificationService $notificationService
     * @param NotificationRepositoryInterface $notificationRepository
     * @param UserTrialRepositoryInterface $userTrialRepository
     */
    public function __construct(
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        UserTrialService $userTrialService
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->userTrialRepository = $userTrialRepository;
        $this->userTrialService = $userTrialService;
    }

    public function handle(CancelledByPartner $event)
    {
        /** @var User $user */
        $partner = $event->partner;
        $this->userTrialService->tempCancelIfValid($partner);
    }
}
