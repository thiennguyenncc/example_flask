<?php


namespace Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Interfaces;


use Illuminate\Support\Collection;

interface ParticipantAwaitingCountSettingRepositoryInterface
{
    /**
     * @param int $gender
     * @param int $datingDayId
     * @param int $prefectureId
     * @return Collection
     */
    public function getSettings(int $gender, int $datingDayId, int $prefectureId): Collection;

    /**
     * @param Collection $models
     * @return bool
     */
    public function saveSettings(Collection $models): bool;
}
