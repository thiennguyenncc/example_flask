<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\FeedbackManagement\DatingReport\Interfaces\DatingReportRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CompletedDatingHasFBByPartnerNoDisplayReport extends AbstractEligibleReceiver
{
    /**
     * @var DatingRepositoryInterface
     */
    protected DatingRepositoryInterface $datingRepository;

    /**
     * @var DatingReportRepositoryInterface
     */
    protected DatingReportRepositoryInterface $datingReportRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var DatingDomainService
     */
    protected DatingDomainService $datingDomainService;

    /**
     * @var Carbon
     */
    public Carbon $fromDatingDate;

    /**
     * @var Carbon
     */
    public Carbon $toDatingDate;

    /**
     * HasDatingFromToGotFeedbackByPartnerNoDisplayReport constructor.
     * @param DatingRepositoryInterface $datingRepository
     * @param DatingReportRepositoryInterface $datingReportRepository
     * @param UserRepositoryInterface $userRepository
     * @param DatingDomainService $datingDomainService
     */
    public function __construct(
        DatingRepositoryInterface $datingRepository,
        DatingReportRepositoryInterface $datingReportRepository,
        UserRepositoryInterface $userRepository,
        DatingDomainService $datingDomainService
    )
    {
        $this->datingRepository =$datingRepository;
        $this->datingReportRepository = $datingReportRepository;
        $this->userRepository = $userRepository;
        $this->datingDomainService = $datingDomainService;
    }

    public function retrieve(): Collection
    {
        $datings = $this->datingRepository->getDatingsHasFeedbacksFromTo($this->fromDatingDate, $this->toDatingDate, DatingStatus::Completed);

        $uIdsFBByPartner = $this->datingDomainService->getUIdsCompletedFBByPartner($datings);

        $uIdsReportDisplayedToday = $this->datingReportRepository->getUserIdsReportDisplayDateToday($uIdsFBByPartner);

        $uIdsFBByPartnerNoReport = array_diff($uIdsFBByPartner, $uIdsReportDisplayedToday);

        return $this->userRepository->getByIds($uIdsFBByPartnerNoReport, null, UserStatus::ApprovedUser);
    }
}
