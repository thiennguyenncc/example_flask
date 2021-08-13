<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Application\User\Services\Interfaces\SmsServiceInterface;
use Bachelor\Application\User\Traits\SmsServiceFormatter;
use Bachelor\Domain\NotificationManagement\Sms\Services\SmsDomainService;

class SmsService implements SmsServiceInterface
{
    use SmsServiceFormatter;

    private SmsDomainService $sms;

    public function __construct(SmsDomainService $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Send verification code for user
     *
     * @param array $params
     * @return array
     */
    public function sendVerificationCodeToUser ( array $params ): array
    {
        return $this->sms->sendVerificationCodeToUser(self::formatDataForSendingVerificationCode($params));
    }

    /**
     * Verify Code
     *
     * @param array $params
     * @return array|string
     */
    public function verifyCode ( array $params ) : array
    {
        return $this->sms->verifyCode(self::formatDataForCodeVerification($params));
    }

}
