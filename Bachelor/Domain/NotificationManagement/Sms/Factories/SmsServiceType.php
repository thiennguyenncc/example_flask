<?php

namespace Bachelor\Domain\NotificationManagement\Sms\Factories;

use Bachelor\Domain\Base\Country\Enums\Countries;
use Bachelor\Domain\NotificationManagement\Sms\Enums\SmsProvider;
use Bachelor\Domain\NotificationManagement\Sms\Services\Interfaces\SmsProviderInterface;

class SmsServiceType
{
    /**
     * Provides sms service provider type based on the country
     *
     * @param Countries $country
     * @param string $mobileNumber
     * @param string $smsServiceProvider
     * @return SmsProviderInterface
     */
    public static function instantiate(
        Countries $country,
        string $mobileNumber,
        string $smsServiceProvider = SmsProvider::Media
    ) : SmsProviderInterface
    {
        $smsServiceType = 'Bachelor\\Domain\\NotificationManagement\\Sms\\Models\\'.$country->value['name'].'SmsProvider';
        return new $smsServiceType($smsServiceProvider, $country, $mobileNumber);
    }
}
