<?php

namespace Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Service;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchService;
use Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Interfaces\ParticipantRecommendationSettingRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;

class RecommendationCalculatorService
{
    private ParticipantRecommendationSettingRepositoryInterface $participantRecommendationSettingRepository;

    private ParticipantMainMatchService $participantMainMatchService;

    public function __construct(
        ParticipantRecommendationSettingRepositoryInterface $participantRecommendationSettingRepository,
        ParticipantMainMatchService $participantMainMatchService
    )
    {
        $this->participantRecommendationSettingRepository = $participantRecommendationSettingRepository;
        $this->participantMainMatchService = $participantMainMatchService;
    }

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @param float $currentRatio
     * @return bool
     */
    public function isRecommend(User $user, DatingDay $datingDay, float $currentRatio): bool
    {
        $recommendRatio = $this->participantRecommendationSettingRepository->getRatioBy(
            $user->getGender(),
            $datingDay->getId(),
            Carbon::today()->diffInDays(Carbon::parse($datingDay->getDatingDate())->startOfDay())
        );

        return $user->getGender() == UserGender::Male ?
            $this->maleCalculate($recommendRatio, $currentRatio) :
            $this->femaleCalculate($recommendRatio, $currentRatio);
    }

    /**
     * @param float $recommendRatio
     * @param float $currentRatio
     * @return bool
     */
    private function maleCalculate(float $recommendRatio, float $currentRatio): bool
    {
        return $recommendRatio > 0 && $recommendRatio <= $currentRatio;
    }

    /**
     * @param float $recommendRatio
     * @param float $currentRatio
     * @return bool
     */
    private function femaleCalculate(float $recommendRatio, float $currentRatio): bool
    {
        return $recommendRatio > 0 && $recommendRatio >= $currentRatio;
    }
}
