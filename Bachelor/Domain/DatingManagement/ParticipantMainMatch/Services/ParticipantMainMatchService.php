<?php

namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Enums\AgeGenderLimit;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Enums\AwaitingCountType;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Interfaces\ParticipantAwaitingCountSettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Models\ParticipantAwaitingCountSetting;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantMainMatchProperty;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\ParticipantMainMatchCancelled;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\ParticipantMainMatchCreated;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\Helper\ParticipantImporter;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserProperty;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Log;

class ParticipantMainMatchService
{
    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    /**
     * @var ParticipantAwaitingCountSettingRepositoryInterface
     */
    private ParticipantAwaitingCountSettingRepositoryInterface $participantAwaitingCountSettingRepository;

    /**
     * ParticipantMainMatchService constructor.
     * @param ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
     * @param ParticipantAwaitingCountSettingRepositoryInterface $participantAwaitingCountSettingRepository
     */
    public function __construct(
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        ParticipantAwaitingCountSettingRepositoryInterface $participantAwaitingCountSettingRepository
    )
    {
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->participantAwaitingCountSettingRepository = $participantAwaitingCountSettingRepository;
    }

    /**
     * @param User $user
     * @param Collection | DatingDay[] $datingDays
     * @throws \Exception
     */
    public function participate(User $user, Collection $datingDays): void
    {
        foreach ($datingDays as $datingDay) {
            $newParticipant = $this->participantMainMatchRepository->getLatestByUserAndDay($user, $datingDay);
            if(!$newParticipant){
                $newParticipant = new ParticipantMainMatch($user->getId(), $datingDay->getId());
            }else{
                $newParticipant->setStatus(ParticipantsStatus::Awaiting);
            }

            $newParticipant->setUser($user)->setDatingDay($datingDay);
            if (!$user->getRegistrationCompleted()) { // 2nd-form incomplete
                $newParticipant->setShowSampleDate(true);
            } else {
                $newParticipant->setShowSampleDate(false);
            }

            $this->participantMainMatchRepository->save($newParticipant);
            ParticipantMainMatchCreated::dispatch($newParticipant);
        }
    }

    /**
     * @param User $user
     * @param Collection | DatingDay[] $datingDays
     */
    public function cancelByDays(User $user, Collection $datingDays): void
    {
        foreach ($datingDays as $datingDay) {

            $participant = $this->participantMainMatchRepository
                ->getAwaitingByUserAndDate($user, $datingDay, [ParticipantMainMatchProperty::User, ParticipantMainMatchProperty::DatingDay]);
            if ($participant) {
                $participant->setDatingDay($datingDay);
                $participant->setUser($user);
                $participant->cancel();
                $this->participantMainMatchRepository->save($participant);

                ParticipantMainMatchCancelled::dispatch($participant);
            }
        }
    }

    /**
     * Get domain importer
     *
     * @param string $filePath
     * @return array
     */
    public function importCsv(string $filePath): array
    {
        $importedData = (new ParticipantImporter())->toArray($filePath, null, Excel::CSV);
        $importedData = reset($importedData);
        // remove header
        array_shift($importedData);

        return $importedData;
    }

    /**
     * Migrate participants from file
     *
     * @param array $importData
     * @return array
     */
    public function migrateParticipants(array $importData): array
    {
        return $this->participantMainMatchRepository->importParticipants($importData);
    }

    /**
     * Remove all participants
     *
     * @return bool
     * @throws \Exception
     */
    public function resetLastWeek(): bool
    {
        return $this->participantMainMatchRepository->removeParticipantsInWeek();
    }

    /**
     * cancel all awaiting for user
     *
     * @param User $user
     * @return boolean
     */
    public function cancelAllAwaitingForUser(User $user): bool
    {
        $participants = $this->participantMainMatchRepository->getAwaitingForUser($user);
        return empty($this->cancelAll($participants)['failedParticipants']);
    }

    /**
     * cancel all passed participants
     *
     * @param Collection $participants
     * @return array
     */
    public function cancelAll(Collection $participants): array
    {
        $result = [
            'failedParticipants' => [],
            'succeededParticipants' => []
        ];

        $participants->each(function (ParticipantMainMatch $participant) use (&$result) {
            if (!$participant->cancel()) {
                Log::error($participant->getId() . ' participant cancel is failed');
                $result['failedParticipants'][] = $participant;
                return true;
            }
            $this->participantMainMatchRepository->save($participant);
            $result['succeededParticipants'][] = $participant;
        });

        return $result;
    }

    /**
     * return list of participant of latest dating date per user id
     *
     * @param Collection $participants
     * @return Collection
     */
    public function getListForOldestDatingDayPerUserId(Collection $participants): Collection
    {
        $list = $participants->groupBy(function ($participant) {
            return $participant->getUserId();
        })->map(function ($participantsPerUser) {
            return $participantsPerUser->sortBy(function ($participant) {
                return $participant->getDatingDay()->getDatingDate();
            })->first();
        });

        return $list;
    }

    /**
     * @param int $prefectureId
     * @param DatingDay $datingDay
     * @return float
     */
    public function getFemaleMaleRatio(int $prefectureId, DatingDay $datingDay): float
    {
        $datingDayId = $datingDay->getId();
        $maleSettings = $this->participantAwaitingCountSettingRepository
            ->getSettings(UserGender::Male, $datingDayId, $prefectureId);
        $femaleSettings = $this->participantAwaitingCountSettingRepository
            ->getSettings(UserGender::Female, $datingDayId, $prefectureId);
        $participants = $this->participantMainMatchRepository
            ->getParticipantMainMatchByPrefectureAndDatingDay(
                $prefectureId, 
                $datingDayId, 
                [ParticipantsStatus::Awaiting],
                [
                    ParticipantMainMatchProperty::User, 
                    ParticipantMainMatchProperty::UserInfoUpdatedTime,
                    ParticipantMainMatchProperty::UserProfile
                ]
            );
        $stats = [
            UserGender::Male => 0,
            UserGender::Female => 0,
        ];

        foreach ($participants as $participant) {
            try {
                /** @var ParticipantMainMatch $participant */
                $user = $participant->getUser();
                $userAge = $user->getUserProfile()->getAge();
                $userGender = $user->getGender();
                $userStatus = $user->getStatus();
    
                if ($user->getRegistrationCompleted()) {
                    $stats[$userGender]++;
                } elseif ($userStatus == UserStatus::AwaitingUser) {
                    if ($userGender == UserGender::Male) {
                        if ($userAge < AgeGenderLimit::MALE_YOUNG_AGE_LIMIT) {
                            $stats[UserGender::Male] += $this->getAwaitingCountSettingByType($maleSettings, AwaitingCountType::AwaitingYoung);
                        } elseif ($userAge < AgeGenderLimit::MALE_OLD_AGE_LIMIT) {
                            $stats[UserGender::Male] += $this->getAwaitingCountSettingByType($maleSettings, AwaitingCountType::AwaitingMiddle);
                        } else {
                            $stats[UserGender::Male] += $this->getAwaitingCountSettingByType($maleSettings, AwaitingCountType::AwaitingOld);
                        }
                    } else {
                        if ($userAge < AgeGenderLimit::FEMALE_YOUNG_AGE_LIMIT) {
                            $stats[UserGender::Female] += $this->getAwaitingCountSettingByType($femaleSettings, AwaitingCountType::AwaitingYoung);
                        } else {
                            $stats[UserGender::Female] += $this->getAwaitingCountSettingByType($femaleSettings, AwaitingCountType::AwaitingOld);
                        }
                    }
                } elseif ($userStatus == UserStatus::ApprovedUser) {
                    $approvedTime = $user->getUserInfoUpdatedTime()->getApprovedAt();
                    $isBefore24h = Carbon::now()->diffInHours($approvedTime) > 24;
    
                    if ($userGender == UserGender::Male) {
                        if ($userAge < AgeGenderLimit::MALE_YOUNG_AGE_LIMIT) {
                            $stats[UserGender::Male] += $isBefore24h ?
                                $this->getAwaitingCountSettingByType($maleSettings, AwaitingCountType::ApprovedBefore24hYoung) :
                                $this->getAwaitingCountSettingByType($maleSettings, AwaitingCountType::ApprovedAfter24hYoung);
                        } elseif ($userAge < AgeGenderLimit::MALE_OLD_AGE_LIMIT) {
                            $stats[UserGender::Male] += $isBefore24h ?
                                $this->getAwaitingCountSettingByType($maleSettings, AwaitingCountType::ApprovedBefore24hMiddle) :
                                $this->getAwaitingCountSettingByType($maleSettings, AwaitingCountType::ApprovedAfter24hMiddle);
                        } else {
                            $stats[UserGender::Male] += $isBefore24h ?
                                $this->getAwaitingCountSettingByType($maleSettings, AwaitingCountType::ApprovedBefore24hOld) :
                                $this->getAwaitingCountSettingByType($maleSettings, AwaitingCountType::ApprovedAfter24hOld);
                        }
                    } else {
                        if ($userAge < AgeGenderLimit::FEMALE_YOUNG_AGE_LIMIT) {
                            $stats[UserGender::Female] += $isBefore24h ?
                                $this->getAwaitingCountSettingByType($femaleSettings, AwaitingCountType::ApprovedBefore24hYoung) :
                                $this->getAwaitingCountSettingByType($femaleSettings, AwaitingCountType::ApprovedAfter24hYoung);
                        } else {
                            $stats[UserGender::Female] += $isBefore24h ?
                                $this->getAwaitingCountSettingByType($femaleSettings, AwaitingCountType::ApprovedBefore24hOld) :
                                $this->getAwaitingCountSettingByType($femaleSettings, AwaitingCountType::ApprovedAfter24hOld);
                        }
                    }
                }
            } catch (\Throwable $th) {
                Log::error($th, [
                    'participant_id' => $participant->getId()
                ]);
                continue;
            }
        }

        return $stats[UserGender::Male] ? round($stats[UserGender::Female] / $stats[UserGender::Male] * 100, 3) : 0;
    }

    /**
     * @param Collection $settings
     * @param string $type
     * @return float
     */
    private function getAwaitingCountSettingByType(Collection $settings, string $type): float
    {
        /** @var ParticipantAwaitingCountSetting $setting */
        $setting = $settings->filter(function ($item) use ($type){
            /** @var ParticipantAwaitingCountSetting $item */
            return $item->getType() == $type;
        })->first();
        
        return $setting ? $setting->getCount() : 0;
    }
}
