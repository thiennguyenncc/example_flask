<?php

namespace Bachelor\Application\Admin\Services\Interfaces;


interface AdminChatServiceInterface
{
    /**
     * Get room list
     *
     * @param array $filter
     * @return AdminChatServiceInterface
     */
    public function getRooms(array $filter): AdminChatServiceInterface;

    /**
     * Get room detail
     *
     * @param int $id
     * @return AdminChatServiceInterface
     */
    public function getRoomDetail($id): AdminChatServiceInterface;

    /**
     * Get message list
     *
     * @param array $filter
     * @return AdminChatServiceInterface
     */
    public function getMessage(array $filter): AdminChatServiceInterface;

    /**
     * Format response data
     *
     * @return array
     */
    public function handleApiResponse(): array;
}
