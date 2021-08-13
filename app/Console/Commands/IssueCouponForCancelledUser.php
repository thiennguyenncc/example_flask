<?php


namespace App\Console\Commands;


use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Models\DatingUser;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\UserCoupon\Services\UserCouponDomainService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class IssueCouponForCancelledUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coupon:issue_for_canceled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Issue coupons from canceled dating by partner';

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
    private DatingDomainService $datingService;

    /**
     * @var SubscriptionRepositoryInterface
     */
    private SubscriptionRepositoryInterface $subscriptionRepository;
    /**
     * @var UserTrialService
     */
    private UserTrialService $userTrialService;



    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DatingDayRepositoryInterface $datingDayRepository,
                                DatingRepositoryInterface $datingRepository,
                                UserCouponDomainService $userCouponDomainService,
                                DatingDomainService $datingService,
                                SubscriptionRepositoryInterface $subscriptionRepository,
                                UserTrialService $userTrialService


    )
    {
        $this->datingDayRepository = $datingDayRepository;
        $this->datingRepository = $datingRepository;
        $this->userCouponService = $userCouponDomainService;
        $this->datingService = $datingService;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userTrialService = $userTrialService;

        parent::__construct();
    }


    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        $datingDay = $this->datingDayRepository->getByDate(Carbon::now()->toDateString());

        $this->info('Process coupons');

        $datingUsers = $this->datingRepository->getDatingUsersForDatingDay($datingDay);
        $datingUsersPerUser  = $this->datingService->getListForLastDatingUserPerUser($datingUsers);
        foreach ($datingUsersPerUser as $datingUser)
        {
            /** @var DatingUser $datingUser */
            if ($datingUser->isCanceledByPartner()) {
                $user = $datingUser->getUser();
                if ($user) {
                    if ($user->getGender() === UserGender::Female){
                        $this->userCouponService->issueCoupon($user, CouponType::Bachelor);
                    }
                    if ($user->getGender() === UserGender::Male){
                        $subscription = $this->subscriptionRepository->getAppliedSubscription($user);
                        if ($subscription){
                            $this->userCouponService->issueCoupon($user, CouponType::Dating);
                        }
                    }
                }
            }
        }

        $this->info('done');
    }
}
