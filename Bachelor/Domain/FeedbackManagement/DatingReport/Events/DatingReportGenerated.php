<?php

namespace Bachelor\Domain\FeedbackManagement\DatingReport\Events;

use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DatingReportGenerated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    public Collection $calculateFBs;

    public function __construct(User $user, Collection $calculateFBs)
    {
        $this->user = $user;
        $this->calculateFBs = $calculateFBs;
    }
}
