<?php

namespace Bachelor\Domain\DatingManagement\Dating\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Models\DatingUserCancellForm;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;

/**
 * @method int getId()
 * @method void setId(int $id)
 * @method int getUserId()
 * @method int getDatingId()
 * @method void setDatingId(int $datingId)
 * @method string getPreferredAreas()
 * @method string setPreferredAreas(string $preferredAreas)
 * @method Carbon getCancelledAt()
 * @method void setCancelledAt(Carbon $cancelledAt)
 * @method DatingUserCancellForm getDatingUserCancellForm()
 * @method void setDatingUserCancellForm(DatingUserCancellForm $datingUserCancellForm)
 * @method User getUser()
 * @method void setUser(User $user)
 */
class DatingUser extends BaseDomainModel
{
    /**
     * @var int
     */
    private int $userId;

    /**
     * @var int|null
     */
    private ?int $datingId;

    /**
     * @var Carbon|null
     */
    private ?Carbon $cancelledAt;

    /**
     * @var DatingUserCancellForm|null
     */
    private ?DatingUserCancellForm $datingUserCancellForm;

    /**
     * @var User|null
     */
    private ?User $user;

    /**
     * @var Dating|null
     */
    private ?Dating $dating;

    /**
     * DatingUser constructor.
     *
     * @param int $id
     * @param int $userId
     * @param int|null $datingId
     * @param Carbon|null $cancelledAt
     * @param DatingUserCancellForm|null $datingUserCancellForm
     * @param User|null $user
     */
    public function __construct(
        int $userId,
        int $datingId = null,
        Carbon $cancelledAt = null,
        DatingUserCancellForm $datingUserCancellForm = null,
        User $user = null
    )
    {
        $this->setUserId($userId);
        $this->setDatingId($datingId);
        $this->setCancelledAt($cancelledAt);
        $this->setDatingUserCancellForm($datingUserCancellForm);
        $this->setUser($user);
    }

    /**
     * Get the value of user
     *
     * @return  int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set the value of user
     *
     * @param int $userId
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Get the value of dating
     *
     * @return  int
     */
    public function getDatingId(): int
    {
        return $this->datingId;
    }

    /**
     * Set the value of dating
     *
     * @param int|null $datingId
     * @return void
     */
    public function setDatingId(int $datingId = null): void
    {
        $this->datingId = $datingId;
    }

    /**
     * Get the value of cancelledAt
     *
     * @return  Carbon|null
     */
    public function getCancelledAt(): ?Carbon
    {
        return $this->cancelledAt;
    }

    /**
     * Set the value of cancelledAt
     *
     * @param Carbon|null $cancelledAt
     * @return void
     */
    public function setCancelledAt(?Carbon $cancelledAt = null): void
    {
        $this->cancelledAt = $cancelledAt;
    }

    /**
     * Get the value of datingUserCancellForm
     *
     * @return  DatingUserCancellForm|null
     */
    public function getDatingUserCancellForm(): ?DatingUserCancellForm
    {
        return $this->datingUserCancellForm;
    }

    /**
     * Set the value of datingUserCancellForm
     *
     * @param DatingUserCancellForm|null $datingUserCancellForm
     * @return void
     */
    public function setDatingUserCancellForm(?DatingUserCancellForm $datingUserCancellForm = null): void
    {
        $this->datingUserCancellForm = $datingUserCancellForm;
    }

    /**
     * create or update dating user cancell form
     *
     * @param array $params
     * @return void
     */
    public function createOrUpdateDatingUserCancellForm(array $params): void
    {
        $datingUserCancellForm = $this->getDatingUserCancellForm();
        if ($datingUserCancellForm) {
            $datingUserCancellForm->setDatingUserId($this->getId());
            $datingUserCancellForm->setReasonForCancellation($params['reasonForCancellation']);
            $datingUserCancellForm->setReasonForCancellationOtherText($params['reasonForCancellationOtherText']);
            $datingUserCancellForm->setReasonForCancellationDissatisfactionOtherText($params['reasonForCancellationDissatisfactionOtherText']);
            $datingUserCancellForm->setDetailedReason($params['detailedReason']);
        } else {
            $datingUserCancellForm = new DatingUserCancellForm(
                $this->getId(),
                $params['reasonForCancellation'],
                $params['reasonForCancellationOtherText'],
                $params['reasonForCancellationDissatisfactionOtherText'],
                $params['detailedReason']
            );
            $this->setDatingUserCancellForm($datingUserCancellForm);
        }
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Dating|null
     */
    public function getDating(): ?Dating
    {
        return $this->dating;
    }

    /**
     * @param Dating|null $dating
     */
    public function setDating(?Dating $dating): void
    {
        $this->dating = $dating;
    }

    /**
     * @return ?bool
     */
    public function isCanceledByPartner(): ?bool
    {
        return $this->cancelledAt === null && $this->dating?->getStatus() === DatingStatus::Cancelled;
    }

}
