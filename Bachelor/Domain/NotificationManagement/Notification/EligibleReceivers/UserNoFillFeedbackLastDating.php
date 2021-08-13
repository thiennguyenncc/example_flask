<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;

class UserNoFillFeedbackLastDating extends AbstractEligibleReceiver
{
    /**
     * @var DatingRepositoryInterface
     */
    private DatingRepositoryInterface $datingRepository;

    /**
     * @var DatingDomainService
     */
    private DatingDomainService $datingDomainService;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    private ?Carbon $fromDate = null;

    private ?Carbon $toDate = null;

    /**
     * UserNoFillFeedbackLastWeekend constructor.
     * @param DatingRepositoryInterface $datingRepository
     * @param DatingDomainService $datingDomainService
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        DatingRepositoryInterface $datingRepository,
        DatingDomainService $datingDomainService,
        UserRepositoryInterface $userRepository
    ) {
        $this->datingRepository = $datingRepository;
        $this->datingDomainService = $datingDomainService;
        $this->userRepository = $userRepository;
    }

    /**
     * @return Collection
     */
    public function retrieve(): Collection
    {
        if (! $this->getFromDate() || ! $this->getToDate()) {
            return collect([]);
        }
        $datings = $this->datingRepository->getCompletedDatingWithoutFeedback($this->getFromDate(), $this->getToDate());
        $userIds = $this->datingDomainService->getUIdsNoFBByPartner($datings);

        return $this->userRepository->getByIds($userIds);
    }

    /**
     * @return Carbon|null
     */
    public function getFromDate(): ?Carbon
    {
        return $this->fromDate;
    }

    /**
     * @param Carbon|null $fromDate
     */
    public function setFromDate(?Carbon $fromDate): void
    {
        $this->fromDate = $fromDate;
    }

    /**
     * @return Carbon|null
     */
    public function getToDate(): ?Carbon
    {
        return $this->toDate;
    }

    /**
     * @param Carbon|null $toDate
     */
    public function setToDate(?Carbon $toDate): void
    {
        $this->toDate = $toDate;
    }



}
