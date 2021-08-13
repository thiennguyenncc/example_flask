<?php

namespace Bachelor\Port\Secondary\Database\NotificationManagement\Sms\Repository;
use Bachelor\Domain\NotificationManagement\Sms\Interfaces\NotificationSmsMessageRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Sms\Models\NotificationSmsMessage;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\NotificationManagement\Sms\ModelDao\NotificationSmsMessage as ModelDao;

class EloquentNotificationSmsMessageRepository extends EloquentBaseRepository implements NotificationSmsMessageRepositoryInterface
{
    /**
     * EloquentNotificationLogRepository constructor.
     * @param ModelDao $modelDao
     */
    public function __construct(ModelDao $modelDao)
    {
        parent::__construct($modelDao);
    }

    /**
     * @param int $id
     * @return NotificationSmsMessage|null
     */
    public function getById(int $id): ?NotificationSmsMessage
    {
        $modelDao = $this->createQuery()->where('id', $id)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param string $key
     * @return NotificationSmsMessage|null
     */
    public function getByKey(string $key): ?NotificationSmsMessage
    {
        $modelDao = $this->createQuery()->where('key', $key)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param NotificationSmsMessage $smsNotification
     * @return NotificationSmsMessage
     */
    public function save(NotificationSmsMessage $smsNotification): NotificationSmsMessage
    {
        return $this->createModelDAO($smsNotification->getId())
            ->saveData($smsNotification);
    }

    /**
     * @param NotificationSmsMessage $smsNotification
     * @return bool
     */
    public function delete(NotificationSmsMessage $smsNotification): bool
    {
        return $this->deleteById($smsNotification->getId());
    }
}
