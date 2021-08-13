<?php

namespace App\Console\Commands\Notification\Sms;

use Bachelor\Domain\Base\Country\Enums\Countries;
use Bachelor\Domain\NotificationManagement\Sms\Enums\SmsStatus;
use Bachelor\Domain\NotificationManagement\Sms\Interfaces\NotificationSmsMessageRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Sms\Models\NotificationSmsMessage;
use Bachelor\Domain\NotificationManagement\Sms\Services\SmsDomainService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class QueuedSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private NotificationSmsMessageRepositoryInterface $notificationSmsMessageRepository;

    private SmsDomainService $smsService;

    private NotificationSmsMessage $notificationSmsMessage;

    public function __construct(NotificationSmsMessage $notificationSmsMessage)
    {
        $this->notificationSmsMessageRepository = app()->make(NotificationSmsMessageRepositoryInterface::class);
        $this->smsService = app()->make(SmsDomainService::class);

        $this->notificationSmsMessage = $notificationSmsMessage;
    }

    public function handle()
    {
        try {
            $response = $this->smsService->sendSmsNotification(
                $this->notificationSmsMessage->getUser()->getMobileNumber(),
                $this->notificationSmsMessage->getContent()
            );
            if ($response['status'] == Response::HTTP_OK) {
                $this->notificationSmsMessage->setStatus(SmsStatus::Success);
            } else {
                $this->notificationSmsMessage->setStatus(SmsStatus::Fail);
            }
            $this->notificationSmsMessageRepository->save($this->notificationSmsMessage);
        } catch (\Throwable $th) {
            Log::error($th, [
                'user_id' => $this->notificationSmsMessage->getUser()->getId(),
                'key' => $this->notificationSmsMessage->getKey(),
            ]);
        }
    }
}
