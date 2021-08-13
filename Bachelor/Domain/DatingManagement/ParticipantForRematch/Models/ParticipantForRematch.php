<?php

namespace Bachelor\Domain\DatingManagement\ParticipantForRematch\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Enums\ParticipantForRematchStatus;

class ParticipantForRematch extends BaseDomainModel
{

    private DatingDay $datingDay;

    private int $userId;

    private int $status = ParticipantForRematchStatus::Awaiting;

    public function __construct(int $userId, DatingDay $datingDay, int $status)
    {
        $this->setUserId($userId);
        $this->setDatingDay($datingDay);
        $this->setStatus($status);
    }

    /**
     * Set value of dating day
     *
     * @param DatingDay $datingDay
     */
    public function setDatingDay(DatingDay $datingDay)
    {
        $this->datingDay = $datingDay;
    }

    /**
     * Get value of dating day
     *
     * @return DatingDay
     */
    public function getDatingDay(): DatingDay
    {
        return $this->datingDay;
    }

    /**
     * Set status of participant rematching record
     *
     * @param int $status
     * @throws ValidationException
     */
    public function setStatus(int $status = ParticipantForRematchStatus::Awaiting): void
    {
        $validator = validator([
            'status' => $status
        ], [
            'status' => [
                Rule::in(ParticipantForRematchStatus::getValues())
            ]
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->status = $status;
    }

    /**
     * Check if participant status is participated status
     *
     * @return boolean
     */
    public function isParticipatedStatusParticipant()
    {
        $validator = validator([
            'status' => $this->status
        ], [
            'status' => [
                Rule::in(ParticipantForRematchStatus::Awaiting)
            ]
        ]);
        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    /**
     * Get the value of user
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of user
     *
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the value of status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }


    /**
     * Set cancellation status
     *
     * @return ParticipantForRematch
     */
    public function cancel(): ParticipantForRematch
    {
        $this->setStatus(ParticipantForRematchStatus::Cancelled);

        return $this;
    }
}
