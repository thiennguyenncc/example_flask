<?php

namespace Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount;

use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\Invoice\Enum\InvoiceStatus;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Models\Invoice;
use Bachelor\Domain\PaymentManagement\Payment\Events\GracePeriodExpired;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Facades\Log;

class UncollectiveDeactivatedAccountNotification
{
    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @var NotificationRepositoryInterface
     */
    protected NotificationRepositoryInterface $notificationRepository;

    /**
     * @var InvoiceRepositoryInterface
     */
    protected InvoiceRepositoryInterface $invoiceRepository;

    public function __construct(
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository,
        InvoiceRepositoryInterface $invoiceRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function handle(GracePeriodExpired $event)
    {
        /** @var User $user */
        $user = $event->user;

        if ($user->getGender() == UserGender::Male) {
            $key = config('notification_keys.uncollective_deactivated_for_male_user');
        } else {
            $key = config('notification_keys.uncollective_deactivated_for_female_user');
        }

        $notification = $this->notificationRepository->getByKey($key);
        if (!$notification) {
            Log::info('Notification is not found.');
            return;
        }
        $invoices = $this->invoiceRepository->getAllUnpaidInvoicesByUser($user);
        $hostedInvoiceUrls = '';
        /** @var Invoice $invoice */
        foreach ($invoices as $invoice) {
            $hostedInvoiceUrls = $hostedInvoiceUrls . "\n" . $invoice->getHostedInvoiceUrl();
        }
        $notification->mapVariable('hosted_invoice_urls', $hostedInvoiceUrls);
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
