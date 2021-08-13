<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Payment\Repository;

use Bachelor\Domain\PaymentManagement\WebhookLog\Interfaces\WebhookLogRepositoryInterface;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\Payment\ModelDao\WebhookLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentPaymentRepository extends EloquentBaseRepository implements WebhookLogRepositoryInterface
{
    /**
     * EloquentPaymentRepository constructor.
     * @param WebhookLog $webhookLog
     */
    public function __construct(WebhookLog $webhookLog)
    {
        parent::__construct($webhookLog);
    }

    /**
     * Webhook logs
     *
     * @param array $context
     * @return WebhookLog|Builder|Model
     */
    public function webhookLog(array $context)
    {
        return $this->modelDAO->newModelQuery()->create([
            'user_id' => $context['userId'],
            'subscription_id' => $context['subscriptionId'] ?? null,
            'webhook_name' => $context['webhookName'] ?? '',
            'webhook_data' => $context['webhookData'] ?? '',
            'method' => $context['method'] ?? '',
            'type' => $context['type'] ?? '',
        ]);
    }
}
