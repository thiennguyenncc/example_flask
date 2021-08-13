<?php

namespace Bachelor\Application\Admin\Services\Interfaces;

use Bachelor\Port\Secondary\Database\NotificationManagement\Notification\ModelDao\Notification;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

interface AdminNotificationServiceInterface
{
    /**
     * Retrieve all notifications
     *
     * @return AdminNotificationServiceInterface
     */
    public function retrieveAllNotifications() : AdminNotificationServiceInterface;

    /**
     * Retrieve notifications by type
     * @param string $type
     * @param string|null $search
     * @return AdminNotificationServiceInterface
     */
    public function retrieveNotificationsByConditions(string $type, ?string $search = ''): AdminNotificationServiceInterface;

    /**
     * Update a notification
     *
     * @param int $id
     * @param array $params
     * @return AdminNotificationServiceInterface
     */
    public function updateNotification(int $id, array $params) : AdminNotificationServiceInterface;

    /**
     * Mark the email notification as read
     *
     * @param string $id
     * @return AdminNotificationServiceInterface
     */
    public function markAsRead(string $id) : AdminNotificationServiceInterface;

    /**
     * Format Registration data
     *
     * @return array
     */
    public function handleApiResponse() : array;
}
