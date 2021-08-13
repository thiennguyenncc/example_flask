<?php

namespace Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Interfaces;

use Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Models\ParticipantRecommendationSetting;
use Illuminate\Support\Collection;

interface ParticipantRecommendationSettingRepositoryInterface
{
    /**
     * @param int $id
     * @return ParticipantRecommendationSetting|null
     */
    public function getById(int $id): ?ParticipantRecommendationSetting;

    /**
     * @param int $gender
     * @param int $dateId
     * @param int $daysBefore
     * @return float
     */
    public function getRatioBy(int $gender, int $dateId, int $daysBefore): float;

    /**
     * @return ParticipantRecommendationSetting[]|Collection
     */
    public function getAll(): Collection;

    /**
     * @param int|null $datingDayId
     * @param int|null $gender
     * @return ParticipantRecommendationSetting[]|Collection
     */
    public function getCollection(?int $datingDayId, ?int $gender): Collection;

    /**
     * @param int $dateId
     * @param int $gender
     * @param array $dayRatios format: [ ['days_before' => int, 'ratio' => float] ]
     */
    public function bulkSet(int $dateId, int $gender, array $dayRatios): void;

    /**
     * @param ParticipantRecommendationSetting $recommendation
     * @return ParticipantRecommendationSetting
     */
    public function save(ParticipantRecommendationSetting $recommendation): ParticipantRecommendationSetting;

    /**
     * @param Collection $recommendations
     * @return bool
     */
    public function saveAll(Collection $recommendations): bool;

    /**
     * @param ParticipantRecommendationSetting $recommendation
     * @return bool
     */
    public function delete(ParticipantRecommendationSetting $recommendation): bool;
}
