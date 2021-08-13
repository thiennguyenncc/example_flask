<?php

namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\UserManagement\UserCoupon\Models\UserCoupon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParticipantMainMatchCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private ParticipantMainMatch $participant;

    public function __construct(ParticipantMainMatch $participant)
    {
        $this->participant = $participant;
    }

    /**
     * @return ParticipantMainMatch
     */
    public function getParticipant(): ParticipantMainMatch
    {
        return $this->participant;
    }
}
