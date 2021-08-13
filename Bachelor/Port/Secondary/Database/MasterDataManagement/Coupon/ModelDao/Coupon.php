<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\ModelDao;

use Bachelor\Domain\MasterDataManagement\Coupon\Models\Coupon as CouponDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\Traits\CouponRelationshipTrait;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\Traits\HasFactory;

class Coupon extends BaseModel
{
    use CouponRelationshipTrait, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupons';

        /**
     * Undocumented function
     *
     * @return CouponDomainModel
     */
    public function toDomainEntity(): CouponDomainModel
    {
        $coupon = new CouponDomainModel(
            $this->name,
            $this->coupon_type,
        );
        $coupon->setId($this->getKey());

        return $coupon;
    }

    /**
        * @TODO: implement all properties
        */
    protected function fromDomainEntity($coupon)
    {
        $this->id = $coupon->getId();
        $this->name = $coupon->getName();
        $this->coupon_type = $coupon->getCouponType();

        return $this;
    }
}
