<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Application\User\Services\Interfaces\NotificationServiceInterface;
use Bachelor\Domain\NotificationManagement\Email\Interfaces\NotificationEmailMessageRepositoryInterface;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Http\Response;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService as NotificationDomainService;

class NotificationService implements NotificationServiceInterface
{
    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var NotificationEmailMessageRepositoryInterface
     */
    private NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository;

    private NotificationDomainService $notificationDomainService;

    /**
     * NotificationService constructor.
     * @param NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository
     */
    public function __construct(NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository,
                                NotificationDomainService $notificationDomainService)
    {
        $this->notificationEmailMessageRepository = $notificationEmailMessageRepository;
        $this->notificationDomainService = $notificationDomainService;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * @param string $id
     * @return array
     */
    public function markEmailNotificationAsRead(string $id): array
    {
        $notificationEmailId = (int) Utility::decode($id);
        $checkPreviousNotificationRead = $this->notificationDomainService->past3SecAfterLastRead($notificationEmailId);
        if ($checkPreviousNotificationRead) {
            $this->notificationEmailMessageRepository->markAsRead($notificationEmailId);
        }

        return $this->handleApiResponse();
    }

    /**
     * Format Registration data
     *
     * @return array
     */
    public function handleApiResponse() : array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
