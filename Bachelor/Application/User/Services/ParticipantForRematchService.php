<?php
namespace Bachelor\Application\User\Services;

use Bachelor\Domain\DatingManagement\Dating\Event\CancelledByPartnerNoRematch;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Services\ParticipantForRematchDomainService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Events\ParticipantForRematchCancelled;
use Bachelor\Domain\UserManagement\User\Models\User;

class ParticipantForRematchService
{

    private int $status;

    private string $message;

    private array $data = [];

    private ParticipantForRematchDomainService $participantForRematchDomainService;

    private DatingDayRepositoryInterface $datingDayRepository;

    private DatingRepositoryInterface $datingRepository;

    public function __construct(
        ParticipantForRematchDomainService $participantForRematchDomainService,
        DatingDayRepositoryInterface $datingDayRepository,
        DatingRepositoryInterface $datingRepository
    ) {
        $this->participantForRematchDomainService = $participantForRematchDomainService;
        $this->datingDayRepository = $datingDayRepository;
        $this->datingRepository = $datingRepository;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Request to cancel
     *
     * @param array $datingDayIds
     * @return self
     */
    public function requestToCancel(array $datingDayIds): self
    {
        $datingDays = $this->datingDayRepository->getByIds($datingDayIds);
        $user = Auth::user()->getDomainEntity();
        foreach ($datingDays as $datingDay) {
            $this->participantForRematchDomainService->cancelParticipantForRematch($user, $datingDay);
            CancelledByPartnerNoRematch::dispatch($user);
            ParticipantForRematchCancelled::dispatch($user,$datingDay);
        }
        return $this;
    }

    // /**
    //  * Request to participate in rematching
    //  *
    //  * @param array $dateIds
    //  * @return self
    //  */
    // public function requestToParticipate(array $dateIds): self
    // {
    //     $datingDays = $this->datingDayRepository->getByIds($dateIds);

    //     foreach ($datingDays as $datingDay) {

    //         $this->participantForRematchDomainService->participateForRematch(Auth::user()->getDomainEntity(), $datingDay);
    //     }

    //     return $this;
    // }

    /**
     * @param User $user
     * @param int $datingId
     * @return self
     */
    public function participateAfterDatingCancelled(User $user, int $datingId): self
    {
        $dating = $this->datingRepository->getDatingById($datingId);
        $datingDay = $dating->getDatingDay();

        if($this->participantForRematchDomainService->validateParticipateForRematch($user, $datingDay)){
            $this->participantForRematchDomainService->participateForRematch($user, $datingDay);
        } else {
            $this->status = Response::HTTP_UNPROCESSABLE_ENTITY;
            $this->message = __('api_messages.failed');
        }

        return $this;
    }

    /**
     * Format Registration data
     *
     * @return array
     */
    public function handleApiResponse(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
