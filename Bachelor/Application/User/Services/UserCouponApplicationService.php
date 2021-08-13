<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Application\User\Services\Interfaces\UserCouponApplicationServiceInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Domain\UserManagement\UserCoupon\Models\UserCoupon;
use Bachelor\Domain\UserManagement\UserCoupon\Services\UserCouponDomainService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserCouponApplicationService implements UserCouponApplicationServiceInterface
{
    /**
     * Response Status
     */
    private $status;

    /**
     * Response Message
     */
    private $message;

    /**
     * Response data
     *
     * @var array
     */
    private $data = [];

    private UserCouponDomainService $userCoupon;

    private UserCouponRepositoryInterface $userCouponRepository;

    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    public function __construct (
        UserCouponDomainService $userCoupon,
        UserCouponRepositoryInterface $userCouponRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
    ) {
        $this->userCoupon = $userCoupon;
        $this->userCouponRepository = $userCouponRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Retrieve all the user coupons
     *
     * @return UserCouponApplicationServiceInterface
     */
    public function getAllUserCoupon (): UserCouponApplicationServiceInterface
    {
        $users = Auth::user()->getDomainEntity();
        $this->data['participated_count'] = $this->participantMainMatchRepository->getAwaitingForUsersInSameWeek([$users], Carbon::now())->count();
        $coupons = $this->userCouponRepository->getAllAvailableCoupon($users);
        $this->data['coupons'] = $coupons->transform(function(UserCoupon $coupon) {
            return [
                'id' => $coupon->getId(),
                'coupon_type' => $coupon->getCoupon()->getCouponType(),
                'name' => $coupon->getCoupon()->getName(),
                'expiry_at' => $coupon->getExpiryAt()->toDateString(),
            ];
        })->toArray();
        return $this;
    }

    /**
     * Issue user coupon
     *
     * @param string $couponType
     * @return UserCouponApplicationServiceInterface
     * @throws Exception
     */
    public function issueUserCoupon ( string $couponType ): UserCouponApplicationServiceInterface
    {
        $this->userCoupon->issueCoupon(Auth::user()->getDomainEntity(), $couponType);

        return $this;
    }

    /**
     * Purchase user coupon
     *
     * @param string $couponType
     * @return UserCouponApplicationServiceInterface
     * @throws Exception
     */
    public function purchaseUserCoupon ( string $couponType ): UserCouponApplicationServiceInterface
    {
        $this->userCoupon->purchaseCoupon(Auth::user()->getDomainEntity(), $couponType);

        return $this;
    }

    /**
     * Return user coupon
     *
     * @param int $userCouponId
     * @return UserCouponApplicationServiceInterface
     */
    public function returnUserCoupon(int $userCouponId) : UserCouponApplicationServiceInterface
    {
        $user = Auth::user()->getDomainEntity();

        $userCoupon = $this->userCouponRepository->getUserCoupon($user, $userCouponId);

        if ($userCoupon) {
            $this->userCoupon->returnUserCoupon($userCoupon);
        }

        return $this;
    }

    /**
     * Discard user coupons
     *
     * @return UserCouponApplicationServiceInterface
     * @throws Exception
     */
    public function discardUserCoupon() : UserCouponApplicationServiceInterface
    {
        $this->userCoupon->discardUserCoupon(Auth::user()->getDomainEntity());

        return $this;
    }

    /**
     * Apply user coupon
     *
     * @param int $datingDayId
     * @param string $couponType
     * @return UserCouponApplicationServiceInterface
     */
    public function applyUserCoupon(int $datingDayId, string $couponType) : UserCouponApplicationServiceInterface
    {
        $user = Auth::user()->getDomainEntity();

        // right now there is only bachelor coupon can be applied separately from participation
        if ($couponType == CouponType::Bachelor) {
            $participatedHistory = $this->participantMainMatchRepository->getParticipatedHistoryForUser(
                $user,
                Carbon::now()->subWeeks(config('matching.max_weeks'))->startOfWeek()->toDateString()
            );
            /* @var ParticipantMainMatch $participant */
            $participant = $participatedHistory->first(function ($item) use ($datingDayId) {
                /* @var ParticipantMainMatch $item */
                return $item->getDatingDayId() == $datingDayId;
            });
            if ($participant) {
                $this->userCoupon->applyUserCoupon($user, $participant->getDatingDay(), CouponType::Bachelor);
            }
        }
        return $this;
    }

    /**
     * Exchange user coupon
     *
     * @param array $params
     * @return UserCouponApplicationServiceInterface
     * @throws Exception
     */
    public function exchangeUserCoupon ( string $couponType ): UserCouponApplicationServiceInterface
    {
        $this->userCoupon->exchangeUserCoupon(Auth::user()->getDomainEntity(), $couponType);

        return $this;
    }

    /**
     * Format Registration data
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
