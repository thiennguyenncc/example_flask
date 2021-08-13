<?php

namespace Bachelor\Application\User\Providers;

use Bachelor\Application\User\Services\Interfaces\NotificationServiceInterface as NotificationServiceInterfaceProvider;
use Bachelor\Application\User\Services\Interfaces\SmsServiceInterface;
use Bachelor\Application\User\Services\SmsService;
use Bachelor\Domain\NotificationManagement\Email\Interfaces\NotificationEmailMessageRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Sms\Interfaces\NotificationSmsMessageRepositoryInterface;
use Bachelor\Port\Secondary\Database\NotificationManagement\Email\Repository\EloquentNotificationEmailMessageRepository;
use Bachelor\Port\Secondary\Database\NotificationManagement\Notification\Repository\EloquentNotificationRepository;
use Bachelor\Port\Secondary\Database\NotificationManagement\Sms\Repository\EloquentNotificationSmsMessageRepository;
use Bachelor\Port\Secondary\NotificationManagement\Sms\Interfaces\MobileNumberValidatorInterface;
use Bachelor\Port\Secondary\NotificationManagement\Sms\Interfaces\VerificationCodeGeneratorInterface;
use Bachelor\Port\Secondary\NotificationManagement\Sms\Interfaces\VerificationContextInterface;
use Bachelor\Port\Secondary\NotificationManagement\Sms\Repository\MobileNumberValidator;
use Bachelor\Port\Secondary\NotificationManagement\Sms\Repository\VerificationCodeGenerator;
use Bachelor\Port\Secondary\NotificationManagement\Sms\Repository\VerificationContext;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Application
        $this->app->bind(NotificationServiceInterfaceProvider::class, \Bachelor\Application\User\Services\NotificationService::class);
        $this->app->bind(SmsServiceInterface::class, SmsService::class);

        // Repository
        $this->app->bind(NotificationRepositoryInterface::class, EloquentNotificationRepository::class);
        $this->app->bind(NotificationEmailMessageRepositoryInterface::class , EloquentNotificationEmailMessageRepository::class);
        $this->app->bind(NotificationSmsMessageRepositoryInterface::class , EloquentNotificationSmsMessageRepository::class);
        $this->app->bind(MobileNumberValidatorInterface::class, MobileNumberValidator::class);
        $this->app->bind(VerificationCodeGeneratorInterface::class, VerificationCodeGenerator::class);
        $this->app->bind(VerificationContextInterface::class, VerificationContext::class);
    }
}
