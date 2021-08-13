<?php

namespace Bachelor\Domain\DatingManagement\Dating\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\Repository\UserRepository;
use Bachelor\Utility\Helpers\Utility;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * @method int getId()
 * @method void setId(int $id)
 */
class Dating extends BaseDomainModel
{

    /**
     * @var DatingDay
     */
    private DatingDay $datingDay;

    /**
     * @var int
     */
    private int $datingPlaceId;

    /**
     * @var Collection
     */
    private Collection $datingUsers;

    /**
     * @var ?string
     */
    private ?string $startAt;

    /**
     * @var int
     */
    private int $status = DatingStatus::Incompleted;

    /**
     * @var Collection|null
     */
    private ?Collection $feedbacks = null;

    /**
     * @var ?Carbon
     */
    private ?Carbon $createdAt;

    /**
     * Dating constructor.
     *
     * @param DatingDay $datingDay
     * @param int $datingPlaceId
     * @param Collection $datingUsers
     * @param Carbon $startAt
     * @param int $status
     * @param ?Carbon $createdAt
     */
    public function __construct(
        DatingDay $datingDay,
        int $datingPlaceId,
        Collection $datingUsers,
        ?string $startAt = null,
        int $status = DatingStatus::Incompleted,
        ?Carbon $createdAt = null,
    ) {
        $this->setDatingDay($datingDay);
        $this->setDatingPlaceId($datingPlaceId);
        $this->setDatingUsers($datingUsers);
        $this->setStartAt($startAt);
        $this->setStatus($status);
        $this->setCreatedAt($createdAt);
    }

    /**
     * Get the value of datingDay
     *
     * @return  DatingDay
     */
    public function getDatingDay(): DatingDay
    {
        return $this->datingDay;
    }

    /**
     * Set the value of datingDay
     *
     * @param DatingDay $datingDay
     * @return void
     */
    public function setDatingDay(DatingDay $datingDay): void
    {
        $this->datingDay = $datingDay;
    }

    /**
     * Get the value of datingPlace
     *
     * @return  int
     */
    public function getDatingPlaceId(): int
    {
        return $this->datingPlaceId;
    }

    /**
     * Set the value of datingPlace
     *
     * @param int $datingPlaceId
     * @return void
     */
    public function setDatingPlaceId(int $datingPlaceId): void
    {
        $this->datingPlaceId = $datingPlaceId;
    }

    /**
     * Get the value of datingUsers
     *
     * @return  Collection
     */
    public function getDatingUsers(): Collection
    {
        return $this->datingUsers;
    }

    /**
     * Set the value of datingUsers
     *
     * @param Collection $datingUsers
     * @return void
     */
    public function setDatingUsers(Collection $datingUsers): void
    {
        $this->datingUsers = $datingUsers;
    }

    /**
     * Get the value of startAt
     *
     * @return string
     */
    public function getStartAt(): string
    {
        return $this->startAt;
    }

    /**
     * Set the value of startAt
     *
     * @param string|null $startAt
     * @return void
     */
    public function setStartAt(?string $startAt = null): void
    {
        $this->startAt = $startAt;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return void
     */
    public function setStatus(int $status = DatingStatus::Incompleted): void
    {
        $validator = validator(
            [
                'status' => $status
            ],
            [
                'status' => [
                    Rule::in(DatingStatus::getValues())
                ]
            ]
        );
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        if ($status === DatingStatus::Cancelled && $this->status === DatingStatus::Completed) {
            throw new \Exception(__('api_messages.dating.this_dating_has_already_been_completed'));
        }

        $this->status = $status;
    }

    /**
     * cancel dating
     *
     * @param User $user
     * @param array $params
     * @return void
     */
    public function cancel(User $user, array $cancelFormParams = []): void
    {
        $this->setStatus(DatingStatus::Cancelled);
        $datingUser = $this->getDatingUserByUserId($user->getId());
        $datingUser->setCancelledAt(Carbon::now());
        !$cancelFormParams ?: $datingUser->createOrUpdateDatingUserCancellForm($cancelFormParams);
    }

    /**
     * @return self
     */
    public function complete(): self
    {
        $this->setStatus(DatingStatus::Completed);
        return $this;
    }

    /**
     * cancel by partner
     *
     * @param User $user
     * @return void
     */
    public function cancelByPartner(User $user): void
    {
        $this->setStatus(DatingStatus::Cancelled);
        $partnerDatingUser = $this->getPartnerDatingUserByUser($user);
        $partnerDatingUser->setCancelledAt(Carbon::now());
    }

    /**
     * @param User $userId
     * @return DatingUser
     */
    public function getPartnerDatingUserByUser(User $user): DatingUser
    {
        $partnerDatingUser = $this->datingUsers->first(function ($datingUser) use ($user) {
            return ($datingUser->getUserId() !== $user->getId());
        });
        if (!$partnerDatingUser) {
            throw new \Exception(__('api_messages.dating.failed_to_get_dating_partner'));
        }
        return $partnerDatingUser;
    }

    /**
     * @param int $userId
     * @return DatingUser
     */
    public function getDatingUserByUserId(int $userId): DatingUser
    {

        $datingUser = $this->datingUsers->first(function (DatingUser $datingUser) use ($userId) {
            return $datingUser->getUserId() === $userId;
        });
        if (!$datingUser) {
            throw new \Exception(__('api_messages.dating.failed_to_get_dating_user'));
        }
        return $datingUser;
    }

    /**
     * @param int $gender
     * @return DatingUser|null
     */
    public function getDatingUserByGender(int $gender)
    {
        foreach ($this->getDatingUsers() as $datingUser) {
            if ($datingUser->getUser()->getGender() == $gender) {
                return $datingUser;
            }
        }
        return null;
    }

    /**
     * @return Collection|null
     */
    public function getFeedbacks(): ?Collection
    {
        return $this->feedbacks;
    }

    /**
     * @param Collection|null $feedbacks
     */
    public function setFeedbacks(?Collection $feedbacks): void
    {
        $this->feedbacks = $feedbacks;
    }

    /**
     * @return Carbon|null
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    /**
     * @param Carbon|null $createdAt
     */
    public function setCreatedAt(?Carbon $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get feedback URL
     *
     * @param int $datingId
     * @return string
     */
    public function getFeedbackUrl(): string
    {
        $feedbackUrl = config('constants.FEEDBACK_URL') . Utility::encode($this->id);
        return Utility::shortenUrl($feedbackUrl);
    }
}
