<?php

namespace Bachelor\Domain\PaymentManagement\Plan\Events;

use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpgradePlan
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     *
     * @var User
     */
    private User $user;

    /**
     * @var Plan
     */
    private Plan $newPlan;

    /**
     * UpgradePlan constructor.
     * @param User $user
     * @param Plan $newPlan
     */
    public function __construct(User $user, Plan $newPlan)
    {
        $this->user = $user;
        $this->setNewPlan($newPlan);
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Plan
     */
    public function getNewPlan(): Plan
    {
        return $this->newPlan;
    }

    /**
     * @param Plan $newPlan
     */
    public function setNewPlan(Plan $newPlan): void
    {
        $this->newPlan = $newPlan;
    }

}
