<?php


namespace Bachelor\Application\User\EventHandler\Listeners\Feedback;


use Bachelor\Domain\FeedbackManagement\DatingReport\Services\DatingReportDomainService;
use Bachelor\Domain\FeedbackManagement\Feedback\Event\FeedbackCreated;

class HandleCreateDatingReport
{
    /**
     * @var DatingReportDomainService
     */
    protected DatingReportDomainService $datingReportDomainService;

    public function __construct(DatingReportDomainService $datingReportDomainService)
    {
        $this->datingReportDomainService = $datingReportDomainService;
    }

    /**
     * @throws \Exception
     */
    public function handle(FeedbackCreated $event)
    {
        $user = $event->getUser();
        $datingDay = $event->getDatingEntity()->getDatingDay();

        $this->datingReportDomainService->generateDatingReport($user, $datingDay);
    }
}
