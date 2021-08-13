<?php

namespace Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount;

use Bachelor\Domain\UserManagement\User\Events\CancelledAccount;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;

class DiscardAllCoupon
{
    /**
     * @var UserCouponRepositoryInterface
     */
    protected UserCouponRepositoryInterface $userCouponRepository;


    public function __construct(
        UserCouponRepositoryInterface $userCouponRepository
    ) {
        $this->userCouponRepository = $userCouponRepository;
    }

    public function handle(CancelledAccount $event)
    {
        $user = $event->user;
        $this->userCouponRepository->discardAllCouponOfUser($user);
    }
}
