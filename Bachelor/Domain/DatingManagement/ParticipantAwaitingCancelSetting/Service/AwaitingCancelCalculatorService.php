<?php

namespace Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Service;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Interfaces\ParticipantAwaitingCancelSettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;

class AwaitingCancelCalculatorService
{
    private ParticipantAwaitingCancelSettingRepositoryInterface $participantAwaitingCancelSettingRepository;

    private ParticipantMainMatchService $participantMainMatchService;

    public function __construct(
        ParticipantAwaitingCancelSettingRepositoryInterface $participantAwaitingCancelSettingRepository,
        ParticipantMainMatchService $participantMainMatchService
    )
    {
        $this->participantAwaitingCancelSettingRepository = $participantAwaitingCancelSettingRepository;
        $this->participantMainMatchService = $participantMainMatchService;
    }

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @param float $currentRatio
     * @return bool
     */
    public function isAwaitingCancel(User $user, DatingDay $datingDay, float $currentRatio): bool
    {
        $awaitingCancelRatio = $this->participantAwaitingCancelSettingRepository->getRatioBy(
            $user->getGender(),
            $datingDay->getId(),
            Carbon::today()->diffInDays(Carbon::parse($datingDay->getDatingDate())->startOfDay())
        );

        return $user->getGender() == UserGender::Male ?
            $this->maleCalculate($awaitingCancelRatio, $currentRatio) :
            $this->femaleCalculate($awaitingCancelRatio, $currentRatio);
    }

    /**
     * @param float $awaitingCancelRatio
     * @param float $currentRatio
     * @return bool
     */
    private function maleCalculate(float $awaitingCancelRatio, float $currentRatio): bool
    {
        return $awaitingCancelRatio > 0 && $awaitingCancelRatio >= $currentRatio;
    }

    /**
     * @param float $awaitingCancelRatio
     * @param float $currentRatio
     * @return bool
     */
    private function femaleCalculate(float $awaitingCancelRatio, float $currentRatio): bool
    {
        return $awaitingCancelRatio > 0 && $awaitingCancelRatio <= $currentRatio;
    }
}
