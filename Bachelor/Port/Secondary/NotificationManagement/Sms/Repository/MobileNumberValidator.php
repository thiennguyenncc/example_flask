<?php

namespace Bachelor\Port\Secondary\NotificationManagement\Sms\Repository;

use Bachelor\Port\Secondary\NotificationManagement\Sms\Interfaces\MobileNumberValidatorInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Bachelor\Port\Secondary\Database\NotificationManagement\Sms\ModelDao\SmsWhitelist;

class MobileNumberValidator implements MobileNumberValidatorInterface
{
    /**
     * Validate mobile number
     *
     * @param string $mobileNumber
     * @return bool
     * @throws \Exception
     */
    public static function validate ( string $mobileNumber ) : bool
    {
        if (!App::environment('production'))
            if (! in_array($mobileNumber, SmsWhitelist::all()->pluck('mobile_number')->toArray()))
                return false;

        return true;
    }

    /**
     * Check if the number is valid for verification
     *
     * @param string $mobileNumber
     * @return bool
     */
    public static function validateForVerification(string $mobileNumber) : bool
    {
        return Cache::has($mobileNumber);
    }

    /**
     * Does verification
     *
     * @param string $mobileNumber
     * @param int $verificationCode
     * @return bool
     */
    public static function verified(string $mobileNumber, int $verificationCode) :bool
    {
        return Cache::get($mobileNumber) === $verificationCode;
    }

    /**
     * Trim Country code
     *
     * @param string $mobileNumber
     * @param string $countryCode
     * @return bool|string
     */
    public static function trimCountryCode(string $mobileNumber, string $countryCode) : string
    {
        $length = strlen($mobileNumber);

        if(($length == 11 || $length == 12) && substr($mobileNumber, 0, 2) == $countryCode)
            $mobileNumber = substr($mobileNumber, 2);

        return '0'.ltrim($mobileNumber, '0');
    }
}
