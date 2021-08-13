<?php

namespace Bachelor\Domain\NotificationManagement\Email\Interfaces;

use Bachelor\Domain\NotificationManagement\Email\Models\NotificationEmailMessage;
use Illuminate\Support\Collection;

interface NotificationEmailMessageRepositoryInterface
{
    /**
     * @param int $id
     * @return NotificationEmailMessage|null
     */
    public function getById(int $id): ?NotificationEmailMessage;

    /**
     * @param string $key
     * @return NotificationEmailMessage|null
     */
    public function getByKey(string $key): ?NotificationEmailMessage;

    /**
     * @return Collection
     */
    public function getUnread(): Collection;

    /**
     * @param int $notificationEmailId
     * @return NotificationEmailMessage|null
     */

    public function getUserLastReadAtByNotificationEmailId(int $notificationEmailId): ?NotificationEmailMessage;

    /**
     * @param int $id
     * @return NotificationEmailMessage|null
     */
    public function markAsRead(int $id): ?NotificationEmailMessage;

    /**
     * @param NotificationEmailMessage $emailNotification
     * @return NotificationEmailMessage
     */
    public function send(NotificationEmailMessage $emailNotification): NotificationEmailMessage;

    /**
     * @return Collection|NotificationEmailMessage[]
     */
    public function getUnsentSmsEmails(): Collection;

    /**
     * @param NotificationEmailMessage $emailNotification
     * @return NotificationEmailMessage
     */
    public function save(NotificationEmailMessage $emailNotification): NotificationEmailMessage;

    /**
     * @param NotificationEmailMessage $emailNotification
     * @return bool
     */
    public function delete(NotificationEmailMessage $emailNotification): bool;

    /**
     * @param $userId
     * @param array $keys
     * @return NotificationEmailMessage|null
     */
    public function getLastInKeysByUserId(int $userId, array $keys) : ?NotificationEmailMessage;
}
