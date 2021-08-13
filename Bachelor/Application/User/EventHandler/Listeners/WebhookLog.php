<?php

namespace Bachelor\Application\User\EventHandler\Listeners;

use Bachelor\Application\User\EventHandler\Events\DispatchWebhook;
use Bachelor\Domain\PaymentManagement\WebhookLog\Interfaces\WebhookLogRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WebhookLog implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'webhook';

    /**
     * @var WebhookLogRepositoryInterface
     */
    private $webhookLogRepository;

    /**
     * Create the event listener.
     * @param WebhookLogRepositoryInterface $webhookLogRepository
     */
    public function __construct(WebhookLogRepositoryInterface $webhookLogRepository)
    {
        $this->webhookLogRepository = $webhookLogRepository;
    }

    /**
     * Handle the event.
     *
     * @param  DispatchWebhook  $event
     * @return void
     */
    public function handle(DispatchWebhook $event)
    {
        $this->paymentService->webhookLog($event->context);
    }
}
