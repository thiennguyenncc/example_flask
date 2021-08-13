<?php

namespace App\Console\Commands\Notification\Matching;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Models\Notification;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotMatchedRematchingNotification extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:not-matched-rematching {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification for not matched rematching on 13pm dating day';

    protected NotificationRepositoryInterface $notificationRepository;

    protected NotificationService $notificationService;

    /**
     * @var UserCouponRepositoryInterface
     */
    protected UserCouponRepositoryInterface $userCouponRepository;

    /**
     * @var DatingDayRepositoryInterface
     */
    private DatingDayRepositoryInterface $datingDayRepository;


    /**
     * @param NotificationRepositoryInterface $notificationRepository ;
     * @param NotificationService $notificationService ;
     * @param UserCouponRepositoryInterface $userCouponRepository ;
     * @param DatingDayRepositoryInterface $datingDayRepository ;
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        UserCouponRepositoryInterface $userCouponRepository,
        DatingDayRepositoryInterface $datingDayRepository
    )
    {
        $this->userCouponRepository = $userCouponRepository;
        $this->datingDayRepository = $datingDayRepository;
        parent::__construct($notificationRepository, $notificationService);
    }

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.not_matched_rematching_for_female');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.not_matched_rematching_for_male');
        }
        return null;
    }

    protected function proceedSendingNotification(User $user, Notification $notification): void
    {
        $today = Carbon::now()->toDateString();
        $datingDay = $this->datingDayRepository->getByDate($today);
        if (is_null($datingDay)) {
            Log::info('dating day '.$today.' is not exist');
        } else {
            if ($this->userCouponRepository->getAppliedUserCouponsForDatingDate($user, $datingDay->getDatingDate())->isNotEmpty()) {
                $notification->mapVariable('coupon_return_text', __('api_messages.userCoupon.coupon_return_text'));
            }
            parent::proceedSendingNotification($user, $notification);
        }
    }
}
