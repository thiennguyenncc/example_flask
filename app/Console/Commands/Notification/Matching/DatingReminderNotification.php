<?php

namespace App\Console\Commands\Notification\Matching;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\DatingManagement\Dating\Models\DatingUser;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\TrainStation\Interfaces\TrainStationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Models\Notification;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Utility\Helpers\CollectionHelper;
use Bachelor\Domain\UserManagement\User\Enums\UserProperty;
use Carbon\Carbon;

class DatingReminderNotification extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:dating_reminder {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dating reminder on 3pm dating day';

    /**
     * @var DatingRepositoryInterface
     */
    protected DatingRepositoryInterface $datingRepository;

    /**
     * @var TrainStationRepositoryInterface
     */
    protected TrainStationRepositoryInterface $trainStationRepository;

    /**
     * @var DatingPlaceRepositoryInterface
     */
    protected DatingPlaceRepositoryInterface $datingPlaceRepository;

    public function __construct(
        DatingRepositoryInterface $datingRepository,
        TrainStationRepositoryInterface $trainStationRepository,
        DatingPlaceRepositoryInterface $datingPlaceRepository,
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService
    ) {
        parent::__construct($notificationRepository, $notificationService);
        $this->datingRepository = $datingRepository;
        $this->trainStationRepository = $trainStationRepository;
        $this->datingPlaceRepository = $datingPlaceRepository;
    }

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.dating_reminder_for_female_users');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.dating_reminder_for_male_users');
        }

        return null;
    }

    /**
     * @param User $user
     * @param Notification $notification
     */
    protected function proceedSendingNotification(User $user, Notification $notification): void
    {
        $notification->mapVariable('dating_from', $this->variableMapDatas[$user->getId()]['dating_from']);
        $notification->mapVariable('station_name', $this->variableMapDatas[$user->getId()]['station_name']);
        parent::proceedSendingNotification($user, $notification);
    }

    protected function addVariableMapDatas(): void
    {
        $results = [];
        $userIds = CollectionHelper::convEntitiesToPropertyArray($this->eligibleUsers, UserProperty::Id);
        $fromDate = Carbon::now()->startOfDay();
        $toDate = Carbon::now()->endOfDay();
        $datings = $this->datingRepository->getDatingsByUserIdsOnDates($userIds, $fromDate, $toDate, DatingStatus::Incompleted);
        $datingPlaceIds = [];
        /** @var Dating $dating */
        foreach ($datings as $dating) {
            $datingUsers = $dating->getDatingUsers();
            /** @var DatingUser $datingUser */
            foreach ($datingUsers as $datingUser) {
                if (in_array($datingUser->getUserId(), $userIds)) {
                    $results[$datingUser->getUserId()]['dating_from'] =  Carbon::parse($dating->getDatingDay()->getDatingDate())->format('m月d日');
                    $datingPlaceIds[$datingUser->getUserId()] = $dating->getDatingPlaceId();
                }
            }
        }

        $datingPlaces = $this->datingPlaceRepository->getByIds($datingPlaceIds);
        foreach ($datingPlaceIds as $key => $datingPlaceId) {
            $results[$key]['station_name'] =  $datingPlaces->filter(function ($datingPlace) use ($datingPlaceId) {
                return $datingPlace->getId() == $datingPlaceId;
            })->first()->getTrainStation()->getDefaultTrainStationTranslation()->getName();
        }

        $this->variableMapDatas = $results;
    }
}
