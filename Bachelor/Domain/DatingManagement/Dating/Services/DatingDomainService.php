<?php

namespace Bachelor\Domain\DatingManagement\Dating\Services;

use Bachelor\Application\Admin\Services\Interfaces\AdminDatingServiceInterface;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Models\DatingUser;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlace;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\Feedback;
use Bachelor\Domain\PaymentManagement\Invoice\Services\InvoiceService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Carbon\Carbon;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\UserPaymentCustomerRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DatingDomainService
{
    /**
     *
     * @var DatingRepositoryInterface
     */
    private $datingRepository;

    /**
     *
     * @var DatingDayRepositoryInterface
     */
    private $datingDayRepository;

    /**
     *
     * @var UserRepositoryInterface
     */
    private $userRepository;


    /**
     * @var UserPaymentCustomerRepositoryInterface
     */
    private $userPaymentCustomerRepository;

    /**
     * @var DatingPlaceRepositoryInterface
     */
    private $datingPlaceReponsitory;

    /**
     * @var InvoiceService
     */
    private $invoiceService;

    /**
     * DatingDomainService constructor.
     *
     * @param DatingRepositoryInterface $datingRepository
     * @param DatingDayRepositoryInterface $datingDayRepository
     * @param UserRepositoryInterface $userRepository
     * @param UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository
     * @param DatingPlaceRepositoryInterface $datingPlaceReponsitory
     */
    public function __construct(
        DatingRepositoryInterface $datingRepository,
        DatingDayRepositoryInterface $datingDayRepository,
        UserRepositoryInterface $userRepository,
        UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository,
        InvoiceService $invoiceService,
        DatingPlaceRepositoryInterface $datingPlaceReponsitory

    ) {
        $this->datingRepository = $datingRepository;
        $this->datingDayRepository = $datingDayRepository;
        $this->userRepository = $userRepository;
        $this->userPaymentCustomerRepository = $userPaymentCustomerRepository;
        $this->invoiceService = $invoiceService;
        $this->datingPlaceReponsitory = $datingPlaceReponsitory;
    }

    /**
     * Get dating history by week offset (in the past)
     *
     * @param int $weekOffSet
     *            0 = this week, -1 = last week, -2 = last last week and so on
     * @param int|null $status
     * @return array
     */
    public function getDatingHistoryForUsersByWeeks($weekOffSet = 0, $status = null): array
    {
        $from = Carbon::now()->addWeeks($weekOffSet)->startOfWeek();
        $to = Carbon::now()->addWeeks($weekOffSet)->endOfWeek();
        $datings = $this->datingRepository->getDatingsFromTo($from, $to, $status);

        $userDatings = [];

        $datings->each(function ($dating) use (&$userDatings) {
            $dating->getDatingUsers()
                ->each(function ($datingUser) use ($dating, &$userDatings) {
                    $userDatings[$datingUser->getUserId()][] = [
                        'start_at' => $dating->getStartAt()
                            ->toDateTimeString(),
                        'status' => $dating->getStatus()
                    ];
                });
        });
        return $userDatings;
    }

    /**
     * create dating data
     * @param DatingUser $datingMaleUser
     * @param DatingUser $datingFemaleUser
     * @param DatingPlace $datingPlace
     * @param DatingDay $datingDay
     * @param string $startAt
     * @return void
     */
    public function createDating(DatingUser $datingMaleUser, DatingUser $datingFemaleUser, DatingPlace $datingPlace, DatingDay $datingDay, string $startAt): Dating
    {
        $domainUserModelCollection = new Collection();
        $domainUserModelCollection->add($datingMaleUser);
        $domainUserModelCollection->add($datingFemaleUser);
        $datingModel = new Dating(
            $datingDay,
            $datingPlace->getId(),
            $domainUserModelCollection,
            $startAt,
            DatingStatus::Incompleted
        );
        return $this->datingRepository->save($datingModel);
    }

    /**
     * update dating data
     * @param Dating $dating
     * @param User $maleUser
     * @param User $femaleUser
     * @param DatingPlace $datingPlace
     * @param DatingDay $datingDay
     * @param string $startAt
     * @return void
     */
    public function updateDating(Dating $dating, User $maleUser, User $femaleUser, DatingPlace $datingPlace, DatingDay $datingDay, string $startAt): Dating
    {
        $dating->getDatingUserByGender(UserGender::Male)->setUserId($maleUser->getId());
        $dating->getDatingUserByGender(UserGender::Female)->setUserId($femaleUser->getId());
        $dating->setDatingDay($datingDay);
        $dating->setDatingPlaceId($datingPlace != null ? $datingPlace->getId() : null);
        $dating->setStartAt($startAt);
        return $this->datingRepository->save($dating);
    }

    /**
     * Cancel dating
     *
     * @param User $user
     * @param integer $datingId
     * @param array $params
     * @return Dating
     */
    public function cancelDating(User $user, int $datingId, ?array $cancelFormParams = []): Dating
    {
        $dating = $this->datingRepository->getDatingById($datingId);
        $dating->cancel($user, $cancelFormParams);

        return $this->datingRepository->save($dating);
    }

    /**
     * cancel dating by partner
     *
     * @param User $user
     * @param integer $datingId
     * @return Dating
     */
    public function cancelledByPartner(User $user, int $datingId): Dating
    {
        $dating = $this->datingRepository->getDatingById($datingId);
        $dating->cancelByPartner($user);

        return $this->datingRepository->save($dating);
    }

    /**
     *
     * @param int $userId
     * @param int|null $datingId
     * @return bool
     */
    public function isNeedGiveFeedbackBy(int $userId, int $datingId = null): bool
    {
        $datingsNoFeedback = $this->datingRepository->getDatingsNoFeedbackByUserId($userId, DatingStatus::Completed);

        foreach ($datingsNoFeedback as $dating) {
            if ($datingId) {
                if ($datingId == $dating->getId()) {
                    return true;
                }
            }
        }
        if (!$datingsNoFeedback->count()) {
            return false;
        }

        return true;
    }

    /**
     * cancel user's all incompleted dating
     *
     * @param User $user
     * @return Collection
     */
    public function cancelAllIncompletedDatingForUser(User $user): Collection
    {
        $datings = $this->datingRepository->getDatingsByUserId($user->getId(), DatingStatus::Incompleted);
        $datings->each(function (Dating $dating) use ($user) {
            $this->cancelDating($user, $dating->getId());
        });
        return $datings;
    }

    /**
     * validate dating is duplicate by user and dating_day_id with two case is create or update dating
     *
     * @param User $userModel
     * @param int $datingDayId
     * @param Dating|null $updateDating
     * @return bool
     */

    public function isDuplicatedOnSameDatingDay(User $userModel, int $datingDayId, ?Dating $updateDating = null)
    {
        $incompleteDatingsOnADay = $this->datingRepository->getDatingsByUserId($userModel->getId(), DatingStatus::Incompleted, $datingDayId);
        if ($updateDating == null) {
            // case create -> check with all record in database with dating user and dating day is condition
            if ($incompleteDatingsOnADay->isNotEmpty()) {
                return false;
            }
        } else {
            // case update -> check with all records except for the record updating (admin can update only dating time or dating place so we need to ignore record updating in the process of checking user dating and dating day duplication)
            foreach ($incompleteDatingsOnADay as $dating) {
                if ($updateDating->getId() !== $dating->getId()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Filter user ids no feedback of datings
     *
     * @param Collection $datings
     * @return array
     */
    public function getUIdsNoFBByPartner(Collection $datingsWithFeedback): array
    {
        $userIds = [];
        /** @var Dating $dating */
        foreach ($datingsWithFeedback as $dating) {
            $feedbacks = $dating->getFeedbacks();
            if (!$feedbacks || !$feedbacks->count()) {
                $datingUsers = $dating->getDatingUsers();
                /** @var DatingUser $datingUser */
                foreach ($datingUsers as $datingUser) {
                    array_push($userIds, $datingUser->getUserId());
                }
                continue;
            }
            if ($feedbacks->count() == 2) {
                continue;
            }

            if ($feedbacks->count() == 1) {
                /** @var Feedback $feedback */
                $feedback = $feedbacks->first();
                array_push($userIds, $feedback->getFeedbackBy()->getId());
            }
        }

        return $userIds;
    }

    /**
     * @param Collection $datings
     * @return array
     */
    public function getUIdsCompletedFBByPartner(Collection $datingsWithFeedback): array
    {
        $userIds = [];
        /** @var Dating $dating */
        foreach ($datingsWithFeedback as $dating) {
            $feedbacks = $dating->getFeedbacks();
            if (!$feedbacks->count()) {
                continue;
            }
            if ($feedbacks->count() == 2) {
                $datingUsers = $dating->getDatingUsers();
                /** @var DatingUser $datingUser */
                foreach ($datingUsers as $datingUser) {
                    array_push($userIds, $datingUser->getUserId());
                }
                continue;
            }

            if ($feedbacks->count() == 1) {
                /** @var Feedback $feedback */
                $feedback = $feedbacks->first();
                array_push($userIds, $feedback->getFeedbackFor()->getId());
            }
        }

        return $userIds;
    }

    /**
     * @param Collection $datingUsers
     * @return Collection
     */
    public function getListForLastDatingUserPerUser(Collection $datingUsers): Collection
    {
        return $datingUsers->groupBy(function (DatingUser $datingUser) {
            return $datingUser->getUserId();
        })->map(function ($datingUsersByUser) {
            return $datingUsersByUser->sortBy(function (DatingUser $datingUser) {
                return $datingUser->getDating()->getCreatedAt();
            })->last();
        });
    }

    /**
     * @return bool
     */
    public function resetLastWeek(): bool
    {
        return $this->datingRepository->deleteDatingsInWeek();
    }
}
