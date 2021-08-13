<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\DatingManagement\Dating\Enums\DatingProperty;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CompletedDatingNoFBByPartner extends AbstractEligibleReceiver
{
    /**
     * @var DatingRepositoryInterface
     */
    protected DatingRepositoryInterface $datingRepository;

    /**
     * @var DatingDomainService
     */
    protected DatingDomainService $datingDomainService;

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var Carbon
     */
    public Carbon $fromDatingDate;

    /**
     * @var Carbon
     */
    public Carbon $toDatingDate;

    /**
     * UsersNoFeedbackOnSaturdayOrSunday constructor.
     * @param DatingRepositoryInterface $datingRepository
     * @param UserRepositoryInterface $userRepository
     * @param DatingDomainService $datingDomainService
     */
    public function __construct(
        DatingRepositoryInterface $datingRepository,
        UserRepositoryInterface $userRepository,
        DatingDomainService $datingDomainService
    )
    {
        $this->datingRepository =$datingRepository;
        $this->userRepository = $userRepository;
        $this->datingDomainService = $datingDomainService;
    }

    public function retrieve(): Collection
    {
        $datingsWithFBs = $this->datingRepository->getDatingsFromTo(
            $this->fromDatingDate, 
            $this->toDatingDate, 
            DatingStatus::Completed, 
            [DatingProperty::Feedbacks]
        );

        $userIds = $this->datingDomainService->getUIdsNoFBByPartner($datingsWithFBs);

        return $this->userRepository->getByIds($userIds, null, UserStatus::ApprovedUser);
    }
}
