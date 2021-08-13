<?php

namespace Bachelor\Application\User\EventHandler\Listeners\ParticipantMainMatch;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\ParticipantMainMatchCancelled;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Domain\UserManagement\UserCoupon\Services\UserCouponDomainService;
use Carbon\Carbon;

class ReturnCouponsForCancelledParticipant
{
    private UserCouponRepositoryInterface $userCouponRepository;

    private UserCouponDomainService $userCouponService;

    public function __construct(
        UserCouponRepositoryInterface $userCouponRepository,
        UserCouponDomainService $userCouponService
    ) {
        $this->userCouponRepository = $userCouponRepository;
        $this->userCouponService = $userCouponService;
    }

    /**
     * @param ParticipantMainMatchCancelled $event
     * @return void
     */
    public function handle(ParticipantMainMatchCancelled $event)
    {
        $coupons = $this->userCouponRepository->getAppliedUserCouponsForDatingDate(
            $event->getParticipant()->getUser(),
            $event->getParticipant()->getDatingDay()->getDatingDate()
        );

        //we have to return dating coupon once at least
        $shouldReturnDatingCoupon = true;
        if ($coupons->isNotEmpty()){
            foreach ($coupons as $coupon) {
                //if we returned dating coupon we don't need to return any more
                if ($coupon->getCoupon()->getCouponType() === CouponType::Dating)
                    $shouldReturnDatingCoupon = false;
                $this->userCouponService->returnUserCoupon($coupon);
            }
        }
        // if we didn't returned dating coupon
        if ($shouldReturnDatingCoupon){
            // get one dating coupon applied same week
            $coupon = $this->userCouponRepository->getAppliedDatingCouponInSameWeek(
                $event->getParticipant()->getUser(),
                $event->getParticipant()->getDatingDay()->getDatingDate()
            );

            if ($coupon) $this->userCouponService->returnUserCoupon($coupon);
        }
    }
}
