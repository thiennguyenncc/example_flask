<?php

namespace Bachelor\Domain\UserManagement\UserCoupon\Models;

use Carbon\Carbon;
use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\MasterDataManagement\Coupon\Models\Coupon;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserCoupon\Enum\UserCouponCategory;
use Bachelor\Domain\UserManagement\UserCoupon\Enum\UserCouponStatus;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserCoupon extends BaseDomainModel
{

    private int $userId;

    private Coupon $coupon;

    private ?DatingDay $datingDay = null;

    private int $status = UserCouponStatus::Unused;

    private ?Carbon $expiryAt = null;

    private ?Carbon $discardedAt = null;

    private ?User $user = null;

    /**
     * @TODO: implement all properties
     */
    public function __construct(
        int $userId,
        Coupon $coupon,
        ?DatingDay $datingDay = null,
        int $status = UserCouponStatus::Unused,
        ?Carbon $expiryAt = null,
        ?Carbon $discardedAt = null
    )
    {
        $this->setUserId($userId);
        $this->setCoupon($coupon);
        $this->setDatingDay($datingDay);
        $this->setStatus($status);
        $this->setExpiryAt($expiryAt);
        $this->setDiscardedAt($discardedAt);
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return void
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return Coupon
     */
    public function getCoupon(): Coupon
    {
        return $this->coupon;
    }

    /**
     * @param Coupon $coupon
     * @return void
     */
    public function setCoupon(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * @return DatingDay
     */
    public function getDatingDay(): ?DatingDay
    {
        return $this->datingDay;
    }

    /**
     * @param DatingDay $datingDay
     * @return void
     */
    public function setDatingDay(?DatingDay $datingDay = null)
    {
        $this->datingDay = $datingDay;
    }

    /**
     * @return integer
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param integer $status
     * @return void
     */
    public function setStatus(int $status)
    {
        $validator = validator([
            'status' => $status
        ], [
            'status' => [
                Rule::in(UserCouponStatus::getValues())
            ]
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $this->status = $status;
    }

    /**
     * @return Carbon|null
     */
    public function getExpiryAt(): ?Carbon
    {
        return $this->expiryAt;
    }

    /**
     * @param Carbon|null $expiryAt
     * @return void
     */
    public function setExpiryAt(?Carbon $expiryAt = null)
    {
        $this->expiryAt = $expiryAt ?: Carbon::now()->addMonths(2);
    }

    /**
     * @return Carbon|null
     */
    public function getDiscardedAt(): ?Carbon
    {
        return $this->discardedAt;
    }

    /**
     * @param Carbon|null $discardedAt
     * @return self
     */
    public function setDiscardedAt(?Carbon $discardedAt = null)
    {
        $this->discardedAt = $discardedAt;
    }

    /**
     * @param User $user
     * @return self
     */
    public function issue(User $user): self
    {
        if ($user->getGender() === UserGender::Female && $this->coupon->getCouponType() === CouponType::Dating) {
            throw new Exception(__('api_messages.userCoupon.unable_to_issue_dating_coupon_to_female_user'));
        }
        $this->setExpiryAt(Carbon::today()->addMonths(UserCouponCategory::Issued()->value["validity"])->endOfDay());
        return $this;
    }

    /**
     * @param User $user
     * @return self
     */
    public function purchase(User $user): self
    {
        if ($user->getGender() === UserGender::Female && $this->coupon->getCouponType() === CouponType::Dating) {
            throw new Exception(__('api_messages.userCoupon.unable_to_purchase_dating_coupon_to_female_user'));
        }
        $this->setExpiryAt(Carbon::today()->addMonths(UserCouponCategory::Purchased()->value["validity"])->endOfDay());
        return $this;
    }

    /**
     * @param array $params
     * @return self
     */
    public function updateUserCoupon(array $params): self
    {
        !isset($params['couponType']) ?: $this->setCoupon($params['couponType']);
        !isset($params['status']) ?: $this->setStatus($params['status']);
        !isset($params['expiryAt']) ?: $this->setExpiryAt(Carbon::make($params['expiryAt']));
        !isset($params['discardedAt']) ?: $this->setDiscardedAt(Carbon::make($params['discardedAt']));
        return $this;
    }

    /**
     * @return self
     */
    public function return(): self
    {
        $this->setStatus(UserCouponStatus::Unused);
        $this->setDatingDay();
        return $this;
    }

    /**
     * @param DatingDay $datingDay
     * @return self
     */
    public function apply(DatingDay $datingDay): self
    {
        $this->setDatingDay($datingDay);
        $this->setStatus(UserCouponStatus::Used);
        return $this;
    }

    /**
     * @return self
     */
    public function exchange(): self
    {
        $this->setStatus(UserCouponStatus::Exchanged);
        return $this;
    }

    /**
     * @return self
     */
    public function discard(): self
    {
        $this->setDiscardedAt(Carbon::now());
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
