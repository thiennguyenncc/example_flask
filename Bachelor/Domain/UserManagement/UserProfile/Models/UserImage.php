<?php

namespace Bachelor\Domain\UserManagement\UserProfile\Models;

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

class UserImage extends BaseDomainModel
{

    private int $userId;

    private string $fileName;

    private int $isPrimary;

    /**
     * @TODO: implement all properties
     */
    public function __construct(
        int $userId,
        string $fileName,
        int $isPrimary,
    ) {
        $this->setUserId($userId);
        $this->setFileName($fileName);
        $this->setIsPrimary($isPrimary);
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
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @return int
     */
    public function getIsPrimary(): int
    {
        return $this->isPrimary;
    }

    /**
     * @param int $isPrimary
     */
    public function setIsPrimary(int $isPrimary): void
    {
        $this->isPrimary = $isPrimary;
    }

}
