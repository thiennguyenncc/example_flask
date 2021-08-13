<?php

namespace Bachelor\Application\User\EventHandler\Listeners\ParticipantMainMatch;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\ParticipantMainMatchCreated;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\UserCoupon\Services\UserCouponDomainService;
use Carbon\Carbon;

class ApplyCouponsForRequestedParticipant
{
    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    private UserCouponDomainService $userCouponService;

    public function __construct(
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        UserCouponDomainService $userCouponService
    ) {
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->userCouponService = $userCouponService;
    }

    /**
     * @param ParticipantMainMatchCreated $event
     * @return void
     */
    public function handle(ParticipantMainMatchCreated $event)
    {
        $user = $event->getParticipant()->getUser();
        $datingDay = $event->getParticipant()->getDatingDay();

        $needApplyCoupon = $this->participantMainMatchRepository->getParticipatedHistoryForUserInSameWeek(
            $user,
            Carbon::parse($datingDay->getDatingDate())
        )->count() > 1 && $user->getGender() == UserGender::Male;

        if ($needApplyCoupon) {
            $this->userCouponService->applyUserCoupon($user, $datingDay, CouponType::Dating);
        }
    }
}
