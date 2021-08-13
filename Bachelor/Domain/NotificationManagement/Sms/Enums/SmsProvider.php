<?php

namespace Bachelor\Domain\NotificationManagement\Sms\Enums;

use Bachelor\Utility\Enums\StringEnum;

/**
 * @method static static Media()
 * @method static static Twilio()
 */
final class SmsProvider extends StringEnum
{
    const Media =  'Media';
    const Twilio =  'Twilio';
}
