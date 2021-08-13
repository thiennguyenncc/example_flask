<?php

namespace Bachelor\Domain\NotificationManagement\Sms\Interfaces;

use Bachelor\Domain\NotificationManagement\Sms\Models\NotificationSmsMessage;

interface NotificationSmsMessageRepositoryInterface
{
    /**
     * @param int $id
     * @return NotificationSmsMessage|null
     */
    public function getById(int $id): ?NotificationSmsMessage;

    /**
     * @param string $key
     * @return NotificationSmsMessage|null
     */
    public function getByKey(string $key): ?NotificationSmsMessage;

    /**
     * @param NotificationSmsMessage $smsNotification
     * @return NotificationSmsMessage
     */
    public function save(NotificationSmsMessage $smsNotification): NotificationSmsMessage;

    /**
     * @param NotificationSmsMessage $smsNotification
     * @return bool
     */
    public function delete(NotificationSmsMessage $smsNotification): bool;
}
