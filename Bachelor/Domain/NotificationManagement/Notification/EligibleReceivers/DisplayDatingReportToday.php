<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\FeedbackManagement\DatingReport\Interfaces\DatingReportRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;

class DisplayDatingReportToday extends AbstractEligibleReceiver
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var DatingReportRepositoryInterface
     */
    protected DatingReportRepositoryInterface $datingReportRepository;

    public function __construct(
        DatingReportRepositoryInterface $datingReportRepository,
        UserRepositoryInterface $userRepository)
    {
        $this->datingReportRepository = $datingReportRepository;
        $this->userRepository = $userRepository;
    }

    public function retrieve(): Collection
    {
        $userIdsForUpdatedDatingReport = $this->datingReportRepository->getUserIdsReportDisplayDateToday();

        return $this->userRepository->getByIds($userIdsForUpdatedDatingReport, null, UserStatus::ApprovedUser);
    }
}
