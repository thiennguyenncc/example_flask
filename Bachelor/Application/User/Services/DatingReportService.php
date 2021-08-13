<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Application\User\Services\Interfaces\DatingReportServiceInterface;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\DatingReport\Interfaces\DatingReportRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\DatingReport\Services\DatingReportDomainService;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;

class DatingReportService implements DatingReportServiceInterface
{
    /**
     * @var DatingReportDomainService
     */
    protected $datingReportDomainService;

    /**
     * @var DatingRepositoryInterface
     */
    protected DatingRepositoryInterface $datingRepository;

    /**
     * @var DatingReportRepositoryInterface
     */
    protected DatingReportRepositoryInterface $datingReportRepository;

    /**
     * DatingReportService constructor.
     * @param DatingReportDomainService $datingReportDomain
     */
    public function __construct(
        DatingReportDomainService $datingReportDomainService,
        DatingRepositoryInterface $datingRepository,
        DatingReportRepositoryInterface $datingReportRepository
    )
    {
        $this->datingReportDomainService = $datingReportDomainService;
        $this->datingRepository = $datingRepository;
        $this->datingReportRepository = $datingReportRepository;
    }

    /**
     * @param User $user
     * @param null $datingReportId
     * @return array
     */
    public function getDatingReportInfo(User $user, $datingReportId = null): array
    {
        return $this->datingReportDomainService->getDatingReportInfo($user, $datingReportId);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function checkShowPopup(User $user): bool
    {
        $dating = $this->datingRepository->getLatestDatingByUserId($user->getId());
        if (!$dating) {
            return false;
        }
        
        $datingReportsForDating = $this->datingReportRepository->getDatingReportsByUserIdNDatingId($user->getId(), $dating->getId());

        if (now()->gt($dating->getDatingDay()->getDatingReportWillDisplayDate())
            && $datingReportsForDating->isEmpty()
        ) {
            return true;
        }

        return false;
    }
}
