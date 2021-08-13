<?php

namespace Bachelor\Port\Secondary\Database\NotificationManagement\Email\Repository;

use Bachelor\Domain\NotificationManagement\Email\Enums\EmailStatus;
use Bachelor\Domain\NotificationManagement\Email\Interfaces\NotificationEmailMessageRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Email\Models\NotificationEmailMessage;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\NotificationManagement\Email\ModelDao\NotificationEmailMessage as ModelDAO;
use Bachelor\Port\Secondary\Database\NotificationManagement\Email\ModelDao\QueuedEmail;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class EloquentNotificationEmailMessageRepository extends EloquentBaseRepository implements NotificationEmailMessageRepositoryInterface
{
    public function __construct (ModelDAO $modelDao)
    {
        parent::__construct($modelDao);
    }

    /**
     * @param int $id
     * @return NotificationEmailMessage|null
     */
    public function getById(int $id): ?NotificationEmailMessage
    {
        $modelDao = $this->createQuery()->where('id', $id)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param string $key
     * @return NotificationEmailMessage|null
     */
    public function getByKey(string $key): ?NotificationEmailMessage
    {
        $modelDao = $this->createQuery()->where('key', $key)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @return Collection
     */
    public function getUnread(): Collection
    {
        $q = $this->createQuery()->whereNull('read_at');

        return $this->transformCollection($q->get());
    }

    /**
     * @param int $notificationEmailId
     * @return NotificationEmailMessage|null
     */

    public function getUserLastReadAtByNotificationEmailId(int $notificationEmailId): ?NotificationEmailMessage
    {
        $userId = $this->createQuery()->select('user_id')
            ->from('notification_email_messages')
            ->where('id', $notificationEmailId)
            ->first()
            ->user_id;
        $modelDao = $this->createQuery()->where('user_id', $userId)
            ->whereNotNull('read_at')
            ->orderBy('read_at','DESC')
            ->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param int $id
     * @return NotificationEmailMessage|null
     */
    public function markAsRead(int $id): ?NotificationEmailMessage
    {
        $emailNotification = $this->getById($id);

        if ($emailNotification) {
            $emailNotification->setReadAt(Carbon::now());

            return $this->save($emailNotification);
        }
        return null;
    }

    /**
     * @param NotificationEmailMessage $emailNotification
     * @return NotificationEmailMessage
     */
    public function send(NotificationEmailMessage $emailNotification): NotificationEmailMessage
    {
        $email = $emailNotification->getUser()->getEmail();
        if (!in_array($email, config('whitelist_in_dev')['email']) && env('APP_ENV') != 'production') {
            throw new \Exception($email . 'email is not verified!!');
        }

        $queuedEmail = (new QueuedEmail($emailNotification))
            ->replyTo(env('MAIL_REPLY_TO'), env('MAIL_FROM_NAME'));

        Mail::to($email)->send($queuedEmail);

        return $emailNotification;
    }

    /**
     * @return Collection
     */
    public function getUnsentSmsEmails(): Collection
    {
        $q = $this->createQuery()
            ->with(['user', 'notification'])
            ->whereNotNull('notification_id')
            ->where('is_sms_sent', 0)
            ->where('status', EmailStatus::Success)
            ->whereNull('read_at')
            ->whereHas('notification', function (Builder $query) {
                $query->where('follow_interval', '>', 0);
            });

        return $this->transformCollection($q->get());
    }

    /**
     * @param NotificationEmailMessage $emailNotification
     * @return NotificationEmailMessage
     */
    public function save(NotificationEmailMessage $emailNotification): NotificationEmailMessage
    {
        return $this->createModelDAO($emailNotification->getId())
            ->saveData($emailNotification);
    }

    /**
     * @param NotificationEmailMessage $emailNotification
     * @return bool
     */
    public function delete(NotificationEmailMessage $emailNotification): bool
    {
        return $this->deleteById($emailNotification->getId());
    }

    /**
     * @param int $userId
     * @param array $keys
     * @return NotificationEmailMessage|null
     */
    public function getLastInKeysByUserId(int $userId, array $keys) : ?NotificationEmailMessage
    {
        $modelDao = $this->createQuery()
                    ->where('status', EmailStatus::Success)
                    ->whereIn('key', $keys)
                    ->orderBy('id', 'desc')
                    ->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }
}
