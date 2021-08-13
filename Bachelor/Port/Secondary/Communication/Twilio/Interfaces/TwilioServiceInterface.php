<?php


namespace Bachelor\Port\Secondary\Communication\Twilio\Interfaces;

interface TwilioServiceInterface
{
    /**
     * Get token twilio
     *
     * @param $identity
     * @return array
     */
    public function getToken($identity): array;

    /**
     * Get users by ids
     *
     * @param array $ids
     * @return array
     */
    public function getUsersByIds(array $ids): array;

    /**
     * Get channel
     *
     * @param string $type
     * @return array
     */
    public function getChannels($type = 'private'): array;

    /**
     * Get members in rooms
     *
     * @param int $roomId
     * @return array
     */
    public function getMembers(int $roomId): array;

    /**
     * Get member in room with user_id
     *
     * @param string $roomId
     * @param int $userId
     * @return array
     */
    public function getMember(string $roomId, int $userId): array;

    /**
     * Get room messages
     *
     * @param array $query
     * @return array
     */
    public function getRoomMessages(array $query): array;

    /**
     * Create room
     *
     * @param array $roomInfo
     * @return array
     */
    public function createRoom(array $roomInfo): array;

    /**
     * Create users
     *
     * @param array $users
     * @return array
     */
    public function createUsers(array $users):array;

}
