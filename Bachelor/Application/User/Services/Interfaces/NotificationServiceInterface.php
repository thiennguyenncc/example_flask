<?php

namespace Bachelor\Application\User\Services\Interfaces;

interface NotificationServiceInterface
{
    /**
     * @param string $id
     * @return array
     */
    public function markEmailNotificationAsRead(string $id): array;
}
