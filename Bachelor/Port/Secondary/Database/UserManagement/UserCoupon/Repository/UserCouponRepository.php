<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\Repository;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\MasterDataManagement\Coupon\Models\Coupon;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserCoupon\Enum\UserCouponStatus;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Domain\UserManagement\UserCoupon\Models\UserCoupon;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao\UserCoupon as UserCouponDAO;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao\UserCouponHistory;
use Exception;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class UserCouponRepository extends EloquentBaseRepository implements UserCouponRepositoryInterface
{
    /**
     * @var UserCouponHistory
     */
    private UserCouponHistory $couponHistory;

    /**
     * UserCouponRepository constructor.
     * @param UserCouponDAO $modelDAO
     */
    public function __construct(UserCouponDAO $modelDAO, UserCouponHistory $couponHistory)
    {
        parent::__construct($modelDAO);
        $this->couponHistory = $couponHistory;
    }

    /**
     * @param User $user
     * @param int $id
     * @return UserCoupon|null
     */
    public function getUserCoupon(User $user, int $id): ?UserCoupon
    {
        $coupon =  $this->createQuery()->where('user_id', $user->getId())->find($id);
        return $coupon ? $coupon->toDomainEntity() : null;
    }

    /**
     * @param User $user
     * @return UserCoupon|null
     * @throws Exception
     */
    public function getOldestAvailableCoupon(User $user, Coupon $coupon): ?UserCoupon
    {
        $usableCoupon = $this->createQuery()
            ->where('coupon_id',$coupon->getId())
            ->where('user_id',$user->getId())
            ->availableCoupon()
            ->orderBy('expiry_at')
            ->first();

        if (!$usableCoupon) {
            throw new Exception(__('api_messages.userCoupon.no_user_coupon_found'));
        }

        return $usableCoupon->toDomainEntity();
    }

    /**
     * @param User $user
     * @param Coupon|null $coupon
     * @return UserCoupon[]|Collection
     */
    public function getAllAvailableCoupon(User $user, Coupon $coupon = null): ?Collection
    {
        $query = $this->createQuery()
            ->where('user_id',$user->getId())
            ->availableCoupon()
            ->orderBy('expiry_at');
        if($coupon) {
            $query = $query->where('coupon_id',$coupon->getId());
        }
        return $this->transformCollection($query->get());
    }

    /**
     * @param User $user
     * @param Coupon|null $coupon
     * @param int $limit
     * @return UserCoupon[]|Collection
     */
    public function getAppliedUserDatingCoupons(User $user, Coupon $coupon = null, $limit = 0): ?Collection
    {
        $query = $this->createQuery()
            ->where('user_id',$user->getId())
            ->where('dating_day_id','<>',null)
            ->where('status',UserCouponStatus::Used)
            ->limit($limit)
            ->get();
        if($coupon) {
            $query = $query->where('coupon_id',$coupon->getId());
        }
        return $this->transformCollection($query);
    }

    /**
     * @param User $user
     * @param string $datingDate
     * @return Collection
     */
    public function getAppliedUserCouponsForDatingDate(User $user, string $datingDate): Collection
    {
        $collection = $this->createQuery()
            ->where('user_id', $user->getId())
            ->where('status', UserCouponStatus::Used)
            ->whereHas('datingDay', function ($q) use ($datingDate) {
                $q->where('dating_date', '=', $datingDate);
            })
            ->get();
        return $this->transformCollection($collection);
    }

    /**
     * @param User $user
     * @param string $datingDate
     * @return UserCoupon|null
     */
    public function getAppliedDatingCouponInSameWeek(User $user, string $datingDate): ?UserCoupon
    {
        $query = $this->createQuery()
            ->where('user_id', $user->getId())
            ->where('status', UserCouponStatus::Used)
            ->whereHas('datingDay', function ($q) use ($datingDate) {
                $startWeekDate = Carbon::create($datingDate)->startOfWeek(Carbon::MONDAY)->toDateString();
                $endWeekDate = Carbon::create($datingDate)->endOfWeek(Carbon::SUNDAY)->toDateString();
                $q->where('dating_date', '>=', $startWeekDate)->where('dating_date', '<=', $endWeekDate);
            })
            ->whereHas('coupon', function ($q) {
                $q->where('coupon_type', CouponType::Dating);
            })
            ->first();
        return $query?->toDomainEntity();
    }

    /**
     * @param User $user
     * @return UserCoupon[]|Collection
     * @throws Exception
     */
    public function getAllUserCoupon(User $user): ?Collection
    {
        $query = $this->createQuery()
            ->where('user_id',$user->getId())
            ->where('discarded_at',null)
            ->get();
        if($query->count()) {
            return $this->transformCollection($query);
        }
        throw new Exception(__('api_messages.userCoupon.no_coupons_found_for_the_user'));
    }

    /**
     * get User's Coupon by specific condition
     *
     * @param User $user
     * @param string $via
     * @param mixed $couponData
     * @return Collection|null
     */
    public function retrieveUserCouponByCondition(User $user,string $via,$couponData): ?Collection
    {
        $query = $this->createQuery()
            ->where('user_id',$user->getId())
            ->where($via,$couponData)
            ->get()
            ->transform(function($coupon) {
                return $coupon->toDomainEntity();
                }
            );
        return $this->transformCollection($query);
    }

    /**
     * get User's Coupon by specific condition
     *
     * @param User $user
     * @param int $couponId
     * @return Collection|null
     */
    public function retrieveUserCouponById(User $user,int $couponId): ?UserCoupon
    {
        $modelDao = $this->createQuery()
            ->where('user_id',$user->getId())
            ->find($couponId)
            ->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param User $user
     * @param array $ids
     * @return Collection|Coupon[]
     */
    public function retrieveUserCouponByIds(User $user, array $ids): Collection
    {
        return $this->transformCollection(
            $this->createQuery()
                ->where('user_id', $user->getId())
                ->whereIn($this->modelDAO->getKeyName(), $ids)
                ->get()
        );
    }

    /**
     * return bachelor coupon is active or not on dating day
     *
     * @param User $user
     * @param DatingDay $datingDay
     * @return boolean
     */
    public function isActiveCouponOnDatingDay(User $user, DatingDay $datingDay,Coupon $coupon): bool
    {
        $userCoupon = $this->createQuery()
        ->where('user_id', $user->getId())
        ->where('dating_day_id',$datingDay->getId())
        ->where('coupon_id',$coupon->getId())
        ->first();

        return (bool) optional($userCoupon)->toDomainEntity();
    }

    /**
     * @param UserCoupon $userCoupon
     * @return UserCoupon
     */
    public function save(UserCoupon $userCoupon): UserCoupon
    {
        $userCoupon = $this->createModelDAO()->saveData($userCoupon);

        $this->couponHistory->create([
            'user_id' => $userCoupon->getUserId(),
            'coupon_id' => $userCoupon->getCoupon()->getId(),
            'user_coupon_id' => $userCoupon->getId(),
            'action' => UserCouponStatus::getKey($userCoupon->getStatus())
        ])->save();

        return $userCoupon;
    }

    /**
     * @param DatingDay $datingDay
     * @return Collection
     */
    public function getAllAppliedUserCouponsForDatingDay(DatingDay $datingDay): Collection
    {
        $collection = $this->createQuery()
            ->where('status', UserCouponStatus::Used)
            ->where(['dating_day_id' => $datingDay->getId()])
            ->with(['user'])
            ->get();
        return $this->transformCollection($collection);
    }

     /**
     * @param User $user
     * @return bool
     */
    public function discardAllCouponOfUser(User $user): bool
    {
        return $this->createModelDAO()
            ->where('user_id', $user->getId())
            ->whereNull('discarded_at')
            ->update([
                'discarded_at' => Carbon::now()
            ]);
    }
}
