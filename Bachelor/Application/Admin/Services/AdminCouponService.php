<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Application\Admin\Services\Interfaces\AdminCouponServiceInterface;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\UserCoupon\Services\UserCouponDomainService;
use Illuminate\Http\Response;

class AdminCouponService implements AdminCouponServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var UserCouponDomainService
     */
    private UserCouponDomainService $userCouponDomainService;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data = [];

    /**
     * AdminCouponService constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserCouponDomainService $userCoupon
     */
    public function __construct(UserRepositoryInterface $userRepository, UserCouponDomainService $userCouponDomainService)
    {
        $this->userRepository = $userRepository;
        $this->userCouponDomainService = $userCouponDomainService;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Issue coupon
     *
     * @param int $userId
     * @param int[] $couponTypes
     * @return AdminCouponServiceInterface
     * @throws \Exception
     */
    public function issueCoupons($userId, $couponTypes): AdminCouponServiceInterface
    {
        /* @var User $user */
        $user = $this->userRepository->getById($userId);
        if (!$user) throw new \Exception(__('admin_messages.user_not_found'));

        foreach ($couponTypes as $couponType) {

            $this->data[] = $this->userCouponDomainService->issueCoupon($user, $couponType);
        }

        return $this;
    }

    /**
     * Format response data
     *
     * @return array
     */
    public function handleApiResponse() : array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
