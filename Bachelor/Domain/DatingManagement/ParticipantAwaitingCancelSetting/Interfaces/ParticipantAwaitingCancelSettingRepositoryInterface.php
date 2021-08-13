<?php

namespace Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Interfaces;

use Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Models\ParticipantAwaitingCancelSetting;
use Illuminate\Support\Collection;

interface ParticipantAwaitingCancelSettingRepositoryInterface
{
    /**
     * @param int $id
     * @return ParticipantAwaitingCancelSetting|null
     */
    public function getById(int $id): ?ParticipantAwaitingCancelSetting;

    /**
     * @param int $gender
     * @param int $dateId
     * @param int $daysBefore
     * @return float
     */
    public function getRatioBy(int $gender, int $dateId, int $daysBefore): float;

    /**
     * @return ParticipantAwaitingCancelSetting[]|Collection
     */
    public function getAll(): Collection;

    /**
     * @param int|null $datingDayId
     * @param int|null $gender
     * @return ParticipantAwaitingCancelSetting[]|Collection
     */
    public function getCollection(?int $datingDayId, ?int $gender): Collection;

    /**
     * @param int $dateId
     * @param int $gender
     * @param array $dayRatios format: [ ['days_before' => int, 'ratio' => float] ]
     */
    public function bulkSet(int $dateId, int $gender, array $dayRatios): void;

    /**
     * @param ParticipantAwaitingCancelSetting $awaitingCancel
     * @return ParticipantAwaitingCancelSetting
     */
    public function save(ParticipantAwaitingCancelSetting $awaitingCancel): ParticipantAwaitingCancelSetting;

    /**
     * @param Collection $awaitingCancels
     * @return bool
     */
    public function saveAll(Collection $awaitingCancels): bool;

    /**
     * @param ParticipantAwaitingCancelSetting $awaitingCancel
     * @return bool
     */
    public function delete(ParticipantAwaitingCancelSetting $awaitingCancel): bool;
}
