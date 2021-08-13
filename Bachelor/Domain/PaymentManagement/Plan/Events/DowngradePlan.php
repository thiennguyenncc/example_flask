<?php

namespace Bachelor\Domain\PaymentManagement\Plan\Events;

use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DowngradePlan
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
     * @var Plan
     */
    private Plan $currentPlan;

    /**
     * UpgradePlan constructor.
     * @param User $user
     * @param Plan $newPlan
     * @param Plan $currentPlan
     */
    public function __construct(User $user, Plan $newPlan, Plan $currentPlan)
    {
        $this->user = $user;
        $this->setNewPlan($newPlan);
        $this->setCurrentPlan($currentPlan);
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

    /**
     * @return Plan
     */
    public function getCurrentPlan(): Plan
    {
        return $this->currentPlan;
    }

    /**
     * @param Plan $currentPlan
     */
    public function setCurrentPlan(Plan $currentPlan): void
    {
        $this->currentPlan = $currentPlan;
    }
}
