<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao;

use Bachelor\Domain\UserManagement\UserCoupon\Enum\UserCouponStatus;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\Traits\HasFactory;
use Illuminate\Support\Carbon;
use Bachelor\Port\Secondary\Database\Base\BaseModel;

use Bachelor\Domain\UserManagement\UserCoupon\Models\UserCoupon as UserCouponDomainModel;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\Traits\UserCouponRelationshipTrait;

class UserCoupon extends BaseModel
{
    use HasFactory, UserCouponRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_coupons';


    public function scopeAvailableCoupon($query)
    {
        return $query
            ->where('status',UserCouponStatus::Unused)
            ->where('expiry_at','>=',Carbon::now())
            ->where('dating_day_id',null)
            ->where('discarded_at',null);
    }

    /**
     * Undocumented function
     *
     * @return UserCouponDomainModel
     */
    public function toDomainEntity(): UserCouponDomainModel
    {
        $userCoupon = new UserCouponDomainModel(
            $this->user()->first()->id,
            $this->coupon()->first()->toDomainEntity(),
            $this->dating_day_id ? $this->datingDay()->first()->toDomainEntity() : null,
            $this->status,
            Carbon::make($this->expiry_at),
            Carbon::make($this->discarded_at),
        );
        $userCoupon->setId($this->getKey());

        if ($this->relationLoaded('user')) {
            $userCoupon->setUser($this->user->toDomainEntity());
        }

        return $userCoupon;
    }

    /**
        * @TODO: implement all properties
        */
    protected function fromDomainEntity($userCoupon)
    {
        $this->id = $userCoupon->getId();
        $this->user_id = $userCoupon->getUserId();
        $this->coupon_id = $userCoupon->getCoupon()->getId();
        $this->dating_day_id = $userCoupon->getDatingDay() ? $userCoupon->getDatingDay()->getId() : null;
        $this->status = $userCoupon->getStatus();
        $this->expiry_at = $userCoupon->getExpiryAt();
        $this->discarded_at = $userCoupon->getDiscardedAt();

        return $this;
    }
}
