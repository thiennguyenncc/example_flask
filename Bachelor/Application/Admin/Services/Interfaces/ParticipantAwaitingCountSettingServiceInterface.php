<?php

namespace Bachelor\Application\Admin\Services\Interfaces;

interface ParticipantAwaitingCountSettingServiceInterface
{
    /**
     * Count users
     *
     * @param int $prefectureId
     * @param int $dateId
     * @return ParticipantAwaitingCountSettingServiceInterface
     */
    public function countParticipants(int $prefectureId, int $datingDayId): ParticipantAwaitingCountSettingServiceInterface;


    /**
     * Format response data
     *
     * @return array
     */
    public function handleApiResponse(): array;

    /**
     * @param int $prefectureId
     * @param int $datingDayId
     * @param int $gender
     * @return ParticipantAwaitingCountSettingServiceInterface
     */
    public function getSettings(int $prefectureId, int $datingDayId, int $gender): ParticipantAwaitingCountSettingServiceInterface;

    /**
     * @param int $prefectureId
     * @param int $datingDayId
     * @param int $gender
     * @param array $settings
     * @return ParticipantAwaitingCountSettingServiceInterface
     */
    public function updateSettings(int $prefectureId, int $datingDayId, int $gender, array $settings): ParticipantAwaitingCountSettingServiceInterface;
}
