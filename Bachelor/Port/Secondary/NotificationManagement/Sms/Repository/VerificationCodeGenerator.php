<?php

namespace Bachelor\Port\Secondary\NotificationManagement\Sms\Repository;

use Bachelor\Port\Secondary\NotificationManagement\Sms\Interfaces\VerificationCodeGeneratorInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class VerificationCodeGenerator implements VerificationCodeGeneratorInterface
{
    /**
     * Get Code for the specified number
     *
     * @param string $mobileNumber
     * @return string
     */
    public function getVerificationCode (string $mobileNumber) : string
    {
        // return generated verification code
        return self::generateVerificationCode($mobileNumber, config('constants.verification_code_timeout'));

    }


    /**
     * Used to get a verification code
     *
     * @param $mobileNumber
     * @param $timeOut
     * @return mixed
     */
    public static function generateVerificationCode(string $mobileNumber, int $timeOut) :int
    {
        $randNum = rand(1,9).rand(0,9).rand(1,9).rand(1,9);
        $timeOutSec = $timeOut * 60;

        return Cache::remember($mobileNumber, $timeOutSec, function () use ($randNum) {
            return App::environment('production') ?
                (int) $randNum :
                (int) env('VERIFICATION_CODE');
        });
    }
}
