<?php


namespace App\Console\Commands;


use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Models\DatingUser;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\UserCoupon\Enum\UserCouponProperty;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Domain\UserManagement\UserCoupon\Models\UserCoupon;
use Bachelor\Domain\UserManagement\UserCoupon\Services\UserCouponDomainService;
use Bachelor\Utility\Helpers\CollectionHelper;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ReturnCouponFromCanceledDating extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:return';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Return coupons from canceled dating by partner';

    /**
     * @var UserCouponRepositoryInterface
     */
    private UserCouponRepositoryInterface $userCouponRepository;
    /**
     * @var DatingRepositoryInterface
     */
    private DatingRepositoryInterface $datingRepository;
    /**
     * @var DatingDayRepositoryInterface
     */
    private DatingDayRepositoryInterface $datingDayRepository;

    /**
     * @var UserCouponDomainService
     */
    private UserCouponDomainService $userCouponService;
    /**
     * @var DatingDomainService
     */
    private DatingDomainService $datingDomainService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DatingDayRepositoryInterface $datingDayRepository,
                                UserCouponRepositoryInterface $userCouponRepository,
                                DatingRepositoryInterface $datingRepository,
                                UserCouponDomainService $userCouponDomainService,
                                DatingDomainService $datingDomainService
    )
    {
        $this->datingDayRepository = $datingDayRepository;
        $this->userCouponRepository = $userCouponRepository;
        $this->datingRepository = $datingRepository;
        $this->userCouponService = $userCouponDomainService;
        $this->datingDomainService = $datingDomainService;
        parent::__construct();
    }


    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        $datingDay = $this->datingDayRepository->getByDate(Carbon::now()->toDateString());
        $appliedCoupons = $this->userCouponRepository->getAllAppliedUserCouponsForDatingDay($datingDay);

        $this->info('Process coupons');

        $appliedCouponsUserIds = CollectionHelper::convEntitiesToPropertyArray($appliedCoupons, UserCouponProperty::UserId);
        $datingUsers = $this->datingRepository->getDatingUsersForDatingDay($datingDay, $appliedCouponsUserIds);
        $datingUsersPerUser  = $this->datingDomainService->getListForLastDatingUserPerUser($datingUsers);

        foreach ($datingUsersPerUser as $userId => $datingUser)
        {
            /** @var DatingUser $datingUser */
            if ($datingUser->isCanceledByPartner()) {
                $toBeReturnedCoupons = $appliedCoupons->filter(function ($coupon) use ($userId){
                    /** @var UserCoupon $coupon */
                    return $coupon->getUserId() == $userId;
                });

                $user = null;
                foreach ($toBeReturnedCoupons as $userCoupon) {
                    /** @var UserCoupon $userCoupon */
                    $this->userCouponService->returnUserCoupon($userCoupon);
                    $user = $userCoupon->getUser();
                }
            }
        }

        $this->info('done');
    }
}
