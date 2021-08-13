<?php

namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ParticipantMainMatchCancelled
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
