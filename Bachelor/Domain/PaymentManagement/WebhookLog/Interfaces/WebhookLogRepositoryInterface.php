<?php

namespace Bachelor\Domain\PaymentManagement\WebhookLog\Interfaces;

interface WebhookLogRepositoryInterface
{
    /**
     * Webhook logs
     *
     * @param array $context
     * @return mixed
     */
    public function webhookLog(array $context);
}
