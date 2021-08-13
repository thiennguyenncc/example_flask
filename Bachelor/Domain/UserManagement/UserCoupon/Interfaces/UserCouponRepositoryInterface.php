<?php

namespace Bachelor\Domain\UserManagement\UserCoupon\Interfaces;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\MasterDataManagement\Coupon\Models\Coupon;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserCoupon\Models\UserCoupon;
use Illuminate\Support\Collection;

interface UserCouponRepositoryInterface
{
    /**
     * @param User $user
     * @param int $id
     * @return UserCoupon|null
     */
    public function getUserCoupon(User $user, int $id): ?UserCoupon;

    /**
     * @param User $user
     * @param Coupon $coupon
     * @return UserCoupon|null
     */
    public function getOldestAvailableCoupon(User $user, Coupon $coupon): ?UserCoupon;

    /**
     * @param User $user
     * @param Coupon|null $coupon
     * @return Collection|Coupon[]
     */
    public function getAllAvailableCoupon(User $user, Coupon $coupon = null): ?Collection;

    /**
     * @param User $user
     * @param Coupon|null $coupon
     * @param int $limit
     * @return Collection|Coupon[]
     */
    public function getAppliedUserDatingCoupons(User $user, Coupon $coupon = null, $limit = 0): ?Collection;

    /**
     * @param User $user
     * @param string $datingDate
     * @return Collection
     */
    public function getAppliedUserCouponsForDatingDate(User $user, string $datingDate): Collection;

    /**
     * @param User $user
     * @param string $datingDate
     * @return UserCoupon|null
     */
    public function getAppliedDatingCouponInSameWeek(User $user, string $datingDate): ?UserCoupon;

    /**
     * @param DatingDay $datingDay
     * @return Collection|UserCoupon[]
     */
    public function getAllAppliedUserCouponsForDatingDay(DatingDay $datingDay): Collection;

    /**
     * @param User $user
     * @return Collection|Coupon[]
     */
    public function getAllUserCoupon(User $user): ?Collection;

    /**
     * get User's Coupon by specific condition
     *
     * @param User $user
     * @param string $via
     * @param mixed $couponData
     * @return Collection|Coupon[]
     */
    public function retrieveUserCouponByCondition(User $user,string $via,$couponData): ?Collection;

    /**
     * get User's Coupon by id
     *
     * @param User $user
     * @param int $couponId
     * @return UserCoupon|null
     */
    public function retrieveUserCouponById(User $user,int $couponId): ?UserCoupon;

    /**
     * Get User's Coupons by ids
     *
     * @param User $user
     * @param array $ids
     * @return Collection|Coupon[]
     */
    public function retrieveUserCouponByIds(User $user, array $ids): Collection;

    /**
    * return bachelor coupon is active or not on dating day
    *
    * @param User $user
    * @param DatingDay $datingDay
    * @return boolean
    */
   public function isActiveCouponOnDatingDay(User $user, DatingDay $datingDay,Coupon $coupon): bool;

    /**
     * @param UserCoupon $userCoupon
     * @return UserCoupon
     */
    public function save(UserCoupon $userCoupon): UserCoupon;

    /**
     * @param User $user
     * @return bool
     */
    public function discardAllCouponOfUser(User $user): bool;
}
