<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\Repository;

use Bachelor\Domain\MasterDataManagement\Coupon\Interfaces\CouponRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Coupon\Models\Coupon;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\ModelDao\Coupon as CouponDAO;
use Exception;

class CouponRepository extends EloquentBaseRepository implements CouponRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param UserCouponDAO $modelDAO
     */
    public function __construct(CouponDAO $modelDAO)
    {
        parent::__construct($modelDAO);
    }

    /**
     * @param int $id
     * @return Coupon|null
     */
    public function getCouponById(int $id): ?Coupon
    {
        $modelDao = $this->model->find($id);
        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     *
     * @param mixed $value
     * @param string $column
     * @return Coupon|null
     */
    public function getCouponByCouponType(string $couponType): ?Coupon
    {
        $coupon = $this->model->where('coupon_type', $couponType)->first();

        if (!$coupon) {
            throw new Exception(__('api_messages.userCoupon.coupon_type_doesn\'t_exist'));
        }

        return $coupon->toDomainEntity();
    }

    /**
     * @param Coupon $user
     * @return Coupon
     */
    public function save(Coupon $coupon): Coupon
    {
        return $this->createModelDAO($coupon->getId())->saveData($coupon);
    }
}
