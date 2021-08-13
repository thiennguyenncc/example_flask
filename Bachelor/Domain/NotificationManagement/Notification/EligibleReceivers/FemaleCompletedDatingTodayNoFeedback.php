<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;

class FemaleCompletedDatingTodayNoFeedback extends AbstractEligibleReceiver
{
    /**
     * @var DatingRepositoryInterface
     */
    private DatingRepositoryInterface $datingRepository;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var DatingDomainService
     */
    private DatingDomainService $datingDomainService;

    /**
     * FemaleCompletedDatingToday constructor.
     * @param DatingRepositoryInterface $datingRepository
     * @param UserRepositoryInterface $userRepository
     * @param DatingDomainService $datingDomainService
     */
    public function __construct(
        DatingRepositoryInterface $datingRepository,
        UserRepositoryInterface $userRepository,
        DatingDomainService $datingDomainService
    ) {
        $this->datingRepository = $datingRepository;
        $this->userRepository = $userRepository;
        $this->datingDomainService = $datingDomainService;
    }

    /**
     * @return Collection
     */
    public function retrieve(): Collection
    {
        $datings = $this->datingRepository->getDatingsCompletedToday();

        $userIds = $this->datingDomainService->getUIdsNoFBByPartner($datings);

        return $this->userRepository->getByIds($userIds);
    }

}
