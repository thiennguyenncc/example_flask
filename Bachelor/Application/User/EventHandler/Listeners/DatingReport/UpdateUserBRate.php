<?php


namespace Bachelor\Application\User\EventHandler\Listeners\DatingReport;

use Bachelor\Domain\FeedbackManagement\DatingReport\Events\DatingReportGenerated;
use Bachelor\Domain\FeedbackManagement\DatingReport\Services\DatingReportDomainService;
use Bachelor\Domain\FeedbackManagement\Feedback\Event\FeedbackCreated;
use Bachelor\Domain\FeedbackManagement\Feedback\Services\FeedbackDomainService;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Repository\FeedbackRepository;
use Illuminate\Support\Facades\Log;

class UpdateUserBRate
{
    /**
     * @var FeedbackDomainService
     */
    protected FeedbackDomainService $feedbackDomainService;

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        FeedbackDomainService $feedbackDomainService,
        UserRepositoryInterface $userRepository
    )
    {
        $this->feedbackDomainService = $feedbackDomainService;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Exception
     */
    public function handle(DatingReportGenerated $event)
    {
        $user = $event->user;
        $feedbacks = $event->calculateFBs;

        //Calculate bachelor rate
        $bRate = $this->feedbackDomainService->calculateBRate($feedbacks);
        $user->setBRate($bRate);
        $this->userRepository->save($user);
    }
}
