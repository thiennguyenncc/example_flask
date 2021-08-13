<?php

namespace Bachelor\Domain\NotificationManagement\Notification\Factories;

use Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers\AbstractEligibleReceiver;
use Illuminate\Support\Str;

class EligibleReceiversFactory
{
    /**
     * @param string $eligibleUserKey
     * @return AbstractEligibleReceiver
     * @throws \Exception
     */
    public static function create(string $eligibleUserKey)
    {
        $class = 'Bachelor\\Domain\\NotificationManagement\\Notification\\EligibleReceivers\\' . Str::ucfirst(Str::camel($eligibleUserKey));
        if (class_exists($class)) {
            return app()->make($class);
        }
        throw new \Exception(__('Class not found'));
    }
}
