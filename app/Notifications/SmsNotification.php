<?php

namespace App\Notifications;

use Bachelor\Application\Admin\Services\Interfaces\AdminNotificationServiceInterface;
use Bachelor\Application\User\Services\Interfaces\SmsServiceInterface;
use Bachelor\Port\Secondary\Database\NotificationManagement\Notification\ModelDao\Notification as NotificationDao;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notification;

class SmsNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var NotificationDao
     */
    private $notification;

    /*
     * @var Notification Service
     */
    private $notificationService;

    /*
     * @var SmsServiceInterface
     */
    private $smsService;

    /**
     * Create a new notification instance.
     *
     * @param NotificationDao $notification
     * @throws BindingResolutionException
     */
    public function __construct( NotificationDao $notification)
    {
        $this->notification = $notification;
        $this->smsService = app()->make(SmsServiceInterface::class);
        $this->notificationService = app()->make(AdminNotificationServiceInterface::class);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['sms'];
    }

    /**
     * Determine which queues should be used for each notification channel.
     *
     * @return array
     */
    public function viaQueues()
    {
        return [
            'sms' => 'sms-notification-queue'
        ];
    }

    /**
     * Get the sms representation of the notification.
     *
     * @param mixed $notifiable
     * @return void
     */
    public function toSms($notifiable)
    {
        if($this->smsService->sendSmsNotification(array_merge($notifiable->toArray(), $this->notification->toArray()))['status'] === Response::HTTP_OK)
            $this->notificationService->logSmsNotification($this->notification, $notifiable);

        Log::error('Unable to send sms notification for '.$this->notification->key.' for user '.$notifiable->id);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
