<?php

namespace Bachelor\Domain\UserManagement\UserCoupon\Services;

use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponExchange;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\MasterDataManagement\Coupon\Interfaces\CouponRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Exception;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserCoupon\Enum\ValidationMessages;
use Bachelor\Domain\UserManagement\UserCoupon\Models\UserCoupon;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;

class UserCouponDomainService
{
    private CouponRepositoryInterface $couponRepository;
    private UserCouponRepositoryInterface $userCouponRepository;
    private SubscriptionRepositoryInterface $subscriptionRepository;

    /**
     * UserCouponDomainService constructor.
     * @param CouponRepositoryInterface $coupon
     * @param UserCouponRepositoryInterface $userCoupon
     * @param SubscriptionRepositoryInterface $subscriptionRepository
     */
    public function __construct(
        CouponRepositoryInterface $coupon,
        UserCouponRepositoryInterface $userCoupon,
        SubscriptionRepositoryInterface $subscriptionRepository
    ) {
        $this->couponRepository = $coupon;
        $this->userCouponRepository = $userCoupon;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Issue Bachelor Coupon
     *
     * @param User $user
     * @param string $couponType
     * @return UserCoupon
     * @throws Exception
     */
    public function issueCoupon(User $user, string $couponType): UserCoupon
    {
        if ($user->getGender() == UserGender::Female && $couponType == CouponType::Dating) {
            throw new \Exception(__('admin_messages.female_only_have_bachelor_coupon'));
        }

        $coupon = $this->couponRepository->getCouponByCouponType($couponType);

        $newUserCoupon = new UserCoupon($user->getId(), $coupon);
        $newUserCoupon->issue($user);

        return $this->userCouponRepository->save($newUserCoupon);
    }

    /**
     * Purchase user coupon
     *
     * @param User $user
     * @param  string $couponType
     * @return UserCoupon
     * @throws Exception
     */
    public function purchaseCoupon(User $user, string $couponType): UserCoupon
    {
        $coupon = $this->couponRepository->getCouponByCouponType($couponType);


        $newUserCoupon = new UserCoupon($user->getId(), $coupon);
        $newUserCoupon->purchase($user);

        return $this->userCouponRepository->save($newUserCoupon);
    }

    /**
     * @param UserCoupon $userCoupon
     * @return UserCoupon
     * @throws Exception
     */
    public function returnUserCoupon(UserCoupon $userCoupon): UserCoupon
    {
        $userCoupon->return();

        return $this->userCouponRepository->save($userCoupon);
    }

    /**
     * Discard user coupons
     *
     * @param User $user
     * @return bool
     */
    public function discardUserCoupon(User $user): bool
    {
        $userCoupons = $this->userCouponRepository->getAllUserCoupon($user);

        $userCoupons->each(function ($coupon) {
            $coupon->discard();
            return $this->userCouponRepository->save($coupon);
        });
        return true;
    }

    /**
     * Apply user coupon
     *
     * @param User $user
     * @param DatingDay $datingDay
     * @param string $couponType
     * @return UserCoupon
     * @throws Exception
     */
    public function applyUserCoupon(User $user, DatingDay $datingDay, string $couponType): UserCoupon
    {
        $subscription = $this->subscriptionRepository->getAppliedSubscription($user);
        if ($user->getGender() === UserGender::Male && !$subscription) {
            throw BaseValidationException::withMessages(ValidationMessages::TrialMaleUserCantUseCoupon);
        }
        $coupon = $this->couponRepository->getCouponByCouponType($couponType);
        $usableCoupon = $this->userCouponRepository->getOldestAvailableCoupon($user, $coupon);

        if (!$usableCoupon) {
            throw BaseValidationException::withMessages(ValidationMessages::NoAvailableCoupon);
        }
        $usableCoupon->apply($datingDay);
        return $this->userCouponRepository->save($usableCoupon);
    }

    /**
     * Exchange Coupon
     *
     * @param User $user
     * @param string $couponType
     * @return UserCoupon
     * @return UserCoupon
     * @throws Exception
     */
    public function exchangeUserCoupon(User $user, string $couponType): UserCoupon
    {
        $CouponType = ucfirst($couponType);
        $exchangeTarget = CouponExchange::$CouponType();
        $targetCoupon = $this->couponRepository->getCouponByCouponType($exchangeTarget->value['target_type']);

        $usableCoupons = $this->userCouponRepository->getAllAvailableCoupon($user, $targetCoupon);
        if ($usableCoupons->count() < $exchangeTarget->value["required_amount"]) {
            throw BaseValidationException::withMessages(ValidationMessages::NotHaveEnoughCouponToExchange);
        }
        $usableCoupons
            ->take($exchangeTarget->value["required_amount"])
            ->each(function ($coupon) {
                $coupon->exchange();
                return $this->userCouponRepository->save($coupon);
            });
        return $this->issueCoupon($user, $couponType);
    }

    /**
     * user used bachelor coupon on dating day or not
     *
     * @param User $user
     * @param DatingDay $datingDay
     * @return boolean
     */
    public function usedBachelorCouponOnDatingDay(User $user, DatingDay $datingDay): bool
    {
        $coupon = $this->couponRepository->getCouponByCouponType(CouponType::Bachelor);

        return  $this->userCouponRepository->isActiveCouponOnDatingDay($user, $datingDay, $coupon);
    }
}
