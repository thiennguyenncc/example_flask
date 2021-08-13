<?php
namespace Bachelor\Domain\MasterDataManagement\Coupon\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class Coupon extends BaseDomainModel
{
    private string $name = '';

    private string $couponType;

    public function __construct(string $couponType, string $name = '')
    {
        $this->setName($name);
        $this->setCouponType($couponType);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCouponType(): string
    {
        return $this->couponType;
    }

    /**
     * @param string $couponType
     * @return void
     */
    public function setCouponType(string $couponType)
    {
        $validator = validator(['coupon_type' => $couponType], [
            'coupun_type' => Rule::in(CouponType::getValues())
        ]);
        if($validator->errors()->messages()) {
            throw new ValidationException($validator);
        }
        $this->couponType = $couponType;
    }
}
