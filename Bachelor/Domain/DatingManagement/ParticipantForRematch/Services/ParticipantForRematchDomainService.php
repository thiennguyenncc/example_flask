<?php

namespace Bachelor\Domain\DatingManagement\ParticipantForRematch\Services;

use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Events\ParticipantForRematchCancelled;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Interfaces\ParticipantForRematchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Models\ParticipantForRematch;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Enums\ParticipantForRematchStatus;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Enums\ValidationMessages;
use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\Base\Exception\BaseValidationMessages;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\Repository\DatingRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ParticipantForRematchDomainService
{

    /**
     * @var DatingDayRepositoryInterface
     */
    private DatingDayRepositoryInterface $datingDayRepository;
    /**
     * @var ParticipantForRematchRepositoryInterface
     */
    private ParticipantForRematchRepositoryInterface $participantForRematchRepository;
    /**
     * @var DatingRepository
     */
    private DatingRepository $datingRepository;
    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepositoryInterface;

    public function __construct(
        DatingDayRepositoryInterface $datingDayRepository,
        ParticipantForRematchRepositoryInterface $participantForRematchRepository,
        DatingRepository $datingRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepositoryRepository
    ) {
        $this->datingDayRepository = $datingDayRepository;
        $this->participantForRematchRepository = $participantForRematchRepository;
        $this->datingRepository = $datingRepository;
        $this->participantMainMatchRepositoryInterface = $participantMainMatchRepositoryRepository;
    }

    /**
     * Cancel participation for rematching and give coupon
     *
     * @param int $userId
     * @param DatingDay $datingDay
     * @return bool
     */
    public function cancelParticipantForRematch(User $user, DatingDay $datingDay): bool
    {
        return $this->cancelParticipationForRematch($user, $datingDay);
    }

    /**
     * Cancel participation for coupon
     *
     * @param User $user
     * @param DatingDay $datingDay
     * @return bool
     */
    protected function cancelParticipationForRematch(User $user, DatingDay $datingDay): bool
    {
        $participantForRematch = $this->participantForRematchRepository->getByUserAndDatingDay($user, $datingDay);
        if (empty($participantForRematch) || !$participantForRematch->isParticipatedStatusParticipant()) {
            return false;
        }

        $participantForRematch = $participantForRematch->cancel();

        $this->participantForRematchRepository->save($participantForRematch);

        return true;
    }

    /**
     * Participates user in rematching
     *
     * @param User $user
     * @param DatingDay $datingDay
     * @return bool
     */
    public function participateForRematch(User $user, DatingDay $datingDay): bool
    {
        $participantForRematch = $this->participantForRematchRepository->getByUserAndDatingDay($user, $datingDay);
        if (empty($participantForRematch)) {
            $participantForRematch = new ParticipantForRematch($user->getId(), $datingDay, ParticipantForRematchStatus::Awaiting);
            $this->participantForRematchRepository->save($participantForRematch);

            Log::channel('dating')->info('User participated for rematching', [
                'user_id' => $user->getId(),
                'dating_day_id' => $datingDay->getId()
            ]);

            return true;
        }

        return false;
    }

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @return bool
     */
    public function validateParticipateForRematch(User $user, DatingDay $datingDay): bool
    {
        if ($user->getStatus() !== UserStatus::ApprovedUser) {
            throw BaseValidationException::withMessages(BaseValidationMessages::UserInapproved);
        }

        // verify fail when now after rematching time of dating day
        if(Carbon::now()->isAfter($datingDay->getRematchingTime())){
            throw BaseValidationException::withMessages(ValidationMessages::PassedRematchTime);
        }

        if($this->isParticipated($user, $datingDay)) {
            throw BaseValidationException::withMessages(ValidationMessages::AlreadyParticipated);
        }

        $lastDating = $this->datingRepository->getDatingByUserAndDatingDay($user, $datingDay);

        if($lastDating?->getStatus() == DatingStatus::Cancelled){
            return true;
        }

        $participantMainMatch = $this->participantMainMatchRepositoryInterface->getLatestByUserAndDay($user, $datingDay);

        if($user->getGender() == UserGender::Female && $participantMainMatch?->getStatus() == ParticipantsStatus::Unmatched) {
            return true;
        }

        throw BaseValidationException::withMessages(ValidationMessages::NotAllowedUser);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function cancelAllAwaitingForUser(User $user): bool
    {
        $participants = $this->participantForRematchRepository->getAwaitingForUser($user);
        $participants->each(function (ParticipantForRematch $participant) {
            $participant->cancel();
            $this->participantForRematchRepository->save($participant);
        });
        return true;
    }

    private function isParticipated(User $user, DatingDay $datingDay): ?bool
    {
        $participant = $this->participantForRematchRepository->getByUserAndDatingDay($user, $datingDay);
        return in_array($participant?->getStatus(), [
            ParticipantForRematchStatus::Awaiting,
            ParticipantForRematchStatus::Matched
        ]);
    }

    /**
     * @return bool
     */
    public function resetLastWeek(): bool
    {
        return $this->participantForRematchRepository->removeParticipantsInWeek();
    }
}
