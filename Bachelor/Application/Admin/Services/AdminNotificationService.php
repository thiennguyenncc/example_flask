<?php

namespace Bachelor\Application\Admin\Services;

use App\Supports\Collection as CollectionSupport;
use Bachelor\Application\Admin\Services\Interfaces\AdminNotificationServiceInterface;
use Bachelor\Application\Admin\Traits\BulkMessageImporter;
use Bachelor\Domain\NotificationManagement\Email\Enums\EmailStatus;
use Bachelor\Domain\NotificationManagement\Email\Interfaces\NotificationEmailMessageRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Email\Models\NotificationEmailMessage;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\Repository\EloquentPrefectureRepository;
use Bachelor\Utility\Helpers\Utility;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;

class AdminNotificationService implements AdminNotificationServiceInterface
{
    /**
     * Response Status
     */
    protected int $status;

    /**
     * Response Message
     */
    protected string $message;

    /**
     * Response data
     * @var array
     */
    protected array $data = [];

    protected NotificationRepositoryInterface $notificationRepository;

    private NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository;
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    private EloquentPrefectureRepository $prefectureRepository;

    /**
     * @param NotificationRepositoryInterface $notificationRepository
     * @param NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository
     * @param UserRepositoryInterface $userRepository
     * @param EloquentPrefectureRepository $prefectureRepository
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository,
        UserRepositoryInterface $userRepository,
        EloquentPrefectureRepository $prefectureRepository
    )
    {
        $this->notificationRepository = $notificationRepository;
        $this->notificationEmailMessageRepository = $notificationEmailMessageRepository;
        $this->userRepository = $userRepository;
        $this->prefectureRepository = $prefectureRepository;
        $this->status = $this->status = Response::HTTP_OK;;
        $this->message = __('api_messages.successful');
    }

    /**
     * Retrieve all notifications
     *
     * @return AdminNotificationServiceInterface
     */
    public function retrieveAllNotifications() : AdminNotificationServiceInterface
    {
        $this->data = $this->notificationRepository->getPaginateArray();

        return $this;
    }

    /**
     * @param $type
     * @param string|null $search
     * @return AdminNotificationServiceInterface
     */
    public function retrieveNotificationsByConditions($type, ?string $search = ''): AdminNotificationServiceInterface
    {
        // get notifications by type and text search
        $notifications = $this->formatDataNotification($this->notificationRepository->getByConditions($type, $search));
        // create CollectionSupport that can paginate
        $this->data = (new CollectionSupport($notifications))->paginate(10)->toArray();
        // reset keys of data
        $this->data['data'] = array_values($this->data['data']);
        // get all prefectures
        $this->data['all_prefectures'] = $this->formatDataPrefecture($this->prefectureRepository->getAllPrefectures());

        return $this;
    }

    /**
     * @param Collection $notificationData
     * @return array
     */
    private function formatDataNotification(Collection $notificationData): array{
        $notifications = [];
        foreach ($notificationData as $notification) {
            $notificationSample = [];
            $notificationSample['id'] = $notification->getId();
            $notificationSample['key'] = $notification->getKey();
            $notificationSample['eligible_user_key'] = $notification->getEligibleUserKey();
            $notificationSample['prefecture_ids'] = $notification->getPrefectureIds();
            $notificationSample['label'] = $notification->getLabel();
            $notificationSample['status'] = $notification->getStatus();
            $notificationSample['title'] = $notification->getTitle();
            $notificationSample['content'] = $notification->getContent();
            $notificationSample['variables'] = $notification->getVariables();
            $notificationSample['created_at'] = $notification->getCreatedAt();
            $notificationSample['updated_at'] = $notification->getUpdatedAt();

            $notifications[] = $notificationSample;
        }

        return $notifications;
    }

    /**
     * @param Collection $prefectureData
     * @return array
     */
    private function formatDataPrefecture(Collection $prefectureData): array{
        $prefectures = [];
        foreach ($prefectureData as $prefecture) {
            $prefectureSample = [];
            $prefectureSample['id'] = $prefecture->getId();
            $prefectureSample['admin_id'] = $prefecture->getAdminId();
            $prefectureSample['name'] = $prefecture->getName();
            $prefectureSample['country_id'] = $prefecture->getCountryId();
            $prefectureSample['status'] = $prefecture->getStatus();
            $prefectures[] = $prefectureSample;
        }

        return $prefectures;
    }

    /**
     * Update a notification
     *
     * @param int $id
     * @param array $params
     * @return AdminNotificationServiceInterface
     * @throws Exception
     */
    public function updateNotification(int $id, array $params) : AdminNotificationServiceInterface
    {
        $notification = $this->notificationRepository->getById($id);
        if (!$notification) throw new Exception(__('admin_messages.notification_not_found'));

        $notification->setContent($params['content'] ?? $notification->getContent());
        $notification->setLabel($params['label'] ?? $notification->getLabel());
        $notification->setTitle($params['title'] ?? $notification->getTitle());
        $notification->setStatus($params['status'] ?? $notification->getStatus());
        $notification->setPrefectureIds($params['prefecture_ids'] ?? $notification->getPrefectureIds());

        $this->data = [
            'notification' => $this->notificationRepository->save($notification)
        ];

        return $this;
    }

    /**
     * Mark the email notification as read
     *
     * @param string $id
     * @return AdminNotificationServiceInterface
     */
    public function markAsRead(string $id) : AdminNotificationServiceInterface
    {
        $this->notificationEmailMessageRepository->markAsRead((int) Utility::decode($id));

        return $this;
    }

    /**
     * @param string $importedFilePath
     * @return AdminNotificationService
     */
    public function sendBulkMessage(string $importedFilePath): AdminNotificationService
    {
        $importedData = (new BulkMessageImporter())->toArray($importedFilePath, null, Excel::CSV);
        $importedData = $importedData[0];
        array_shift($importedData); // remove header

        $userIds = [];
        $userData = [];

        foreach ($importedData as $col) {
            $userIds[] = $col[0];
            if (!array_key_exists($col[0], $userData)) {
                $userData[$col[0]] = [
                    $col[1] => $col[2]
                ];
            } else {
                $userData[$col[0]] = array_merge($userData[$col[0]], [
                    $col[1] => $col[2]
                ]);
            }
        }

        $users = $this->userRepository->getByIds($userIds);

        $validUserIds = [];
        foreach ($users as $user) {
            $validUserIds[] = $user->getId();
        }
        $invalidUserIds = array_values(array_diff($userIds, $validUserIds));

        foreach ($users as $user) {
            foreach ($userData[$user->getId()] as $title => $message) {
                $notificationEmailMessage = (new NotificationEmailMessage(
                    $user->getId(),
                    '',
                    $title,
                    $message
                ))->setUser($user);
                $this->notificationEmailMessageRepository->save($notificationEmailMessage); // prepare record ID for Mark as read
                $this->notificationEmailMessageRepository->send($notificationEmailMessage)->setStatus(EmailStatus::Success);
                $this->notificationEmailMessageRepository->save($notificationEmailMessage);
            }
        }
        $this->data = [
            'success' => $validUserIds,
            'failure' => $invalidUserIds
        ];

        return $this;
    }

    /**
     * Format Notification data
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
