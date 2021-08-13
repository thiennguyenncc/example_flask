<?php

namespace App\Console\Commands\Notification\Sms;

use App\Console\Commands\BachelorBaseCommand;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\NotificationManagement\Email\Interfaces\NotificationEmailMessageRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Enums\NotificationType;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Sms\Enums\SmsStatus;
use Bachelor\Domain\NotificationManagement\Sms\Interfaces\NotificationSmsMessageRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Sms\Models\NotificationSmsMessage;
use Bachelor\Domain\NotificationManagement\Sms\Services\SmsDomainService;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Runs on: every minute
 * Runs for: all users who not read notification emails
 */
class SendSmsForUnreadEmailUsers extends BachelorBaseCommand
{
    /**
     * @var string
     */
    protected $signature = 'notification:send-sms-for-unread-emails';

    /**
     * @var string
     */
    protected $description = 'Send notification to all users who not read notification emails';

    private NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository;

    private NotificationSmsMessageRepositoryInterface $notificationSmsMessageRepository;

    private NotificationRepositoryInterface $notificationRepository;

    private NotificationService $notificationService;

    private UserRepositoryInterface $userRepository;

    private SmsDomainService $smsService;

    public function __construct(
        NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository,
        NotificationSmsMessageRepositoryInterface $notificationSmsMessageRepository,
        NotificationRepositoryInterface $notificationRepository,
        UserRepositoryInterface $userRepository,
        NotificationService $notificationService,
        SmsDomainService $smsService
    )
    {
        $this->notificationEmailMessageRepository = $notificationEmailMessageRepository;
        $this->notificationSmsMessageRepository = $notificationSmsMessageRepository;
        $this->notificationRepository = $notificationRepository;
        $this->userRepository = $userRepository;
        $this->smsService = $smsService;
        $this->notificationService = $notificationService;

        parent::__construct();
    }

    public function handle()
    {
        Log::info('start notification:send-sms-for-unread-emails');
        $unsentEmails = $this->notificationEmailMessageRepository->getUnsentSmsEmails();

        if ($unsentEmails->count()) {

            // Send only users who is not cancelled or deactivated
            $userIdArray = $unsentEmails->map(function ($email) {
                return $email->getUserId();
            })->toArray();
            
            $notCancelledOrDeactivatedUsers = $this->userRepository->getAllNotInStatusByUserIds($userIdArray, [
                UserStatus::DeactivatedUser,
                UserStatus::CancelledUser
            ]);

            $notCancelledOrDeactivatedUserIdArray = $notCancelledOrDeactivatedUsers->map(function ($user) {
                return $user->getId();
            })->toArray();

            $unsentEmails = $unsentEmails->filter(function ($email) use ($notCancelledOrDeactivatedUserIdArray) {
                return in_array($email->getUserId(), $notCancelledOrDeactivatedUserIdArray);
            });

            foreach ($unsentEmails as $unsentEmail) {
                try {
                    if (!$unsentEmail->getNotification()->getFollowInterval()) return;

                    if ($unsentEmail->getCreatedAt()->diffInSeconds(Carbon::now()) > $unsentEmail->getNotification()->getFollowInterval()) {
                        $notificationSms = $this->notificationRepository->getByKey($unsentEmail->getKey(), NotificationType::Sms);
                        if (!$notificationSms) return;
                        if (is_null($unsentEmail->getContent())) return;
                        $notificationSmsMessage = (new NotificationSmsMessage(
                            $unsentEmail->getUserId(),
                            $unsentEmail->getKey(),
                            $notificationSms->getTitle(),
                            $notificationSms->getContent(),
                            SmsStatus::Processing,
                            $unsentEmail->getNotificationId()
                        ))->setUser($unsentEmail->getUser());

                        $this->notificationSmsMessageRepository->save($notificationSmsMessage);
                        QueuedSms::dispatch($notificationSmsMessage);

                        $unsentEmail->setIsSmsSent(true);
                        $this->notificationEmailMessageRepository->save($unsentEmail);
                    }
                } catch (\Throwable $th) {
                    Log::error($th, [
                        'sms_unsent_email_id' => $unsentEmail->getId()
                    ]);
                }
            }
        }
    }
}
