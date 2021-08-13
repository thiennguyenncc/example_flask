<?php

namespace Bachelor\Domain\PaymentManagement\Invoice\Services;

use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\ExtInvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Models\Invoice;
use Bachelor\Domain\PaymentManagement\Invoice\Models\InvoiceItem;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Services\UserPaymentCustomerService;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Utility\Helpers\Utility;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class InvoiceService
{
    private InvoiceRepositoryInterface $invoiceRepository;
    private ExtInvoiceRepositoryInterface $extInvoiceRepository;

    /**
     * InvoiceService constructor.
     * @param InvoiceRepositoryInterface $invoiceRepository
     * @param ExtInvoiceRepositoryInterface $extInvoiceRepository
     */
    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository,
        ExtInvoiceRepositoryInterface $extInvoiceRepository
    ) {
        $this->invoiceRepository = $invoiceRepository;
        $this->extInvoiceRepository = $extInvoiceRepository;
    }

    /**
     * Pay cancellation fee
     *
     * @param UserPaymentCustomer $userPaymentProvider
     * @param Carbon $datingDate
     * @param Carbon $cancelDate
     * @return bool
     */
    public function createCancellationFeeInvoice(UserPaymentCustomer $userPaymentCustomer, Carbon $datingDate, Carbon $cancelDate): bool
    {
        if ($cancelDate < $datingDate) {
            $amount = config('constants.cancel_charge_not_free_day');
        } else {
            $amount = config('constants.cancel_charge_on_date_day');
        }
        $description = __(
            'api_messages.stripe_api.cancellation_fee_invoice_item_description.' . App::getLocale(),
            ["dating_date" => date('Y-m-d', strtotime($datingDate))]
        );

        $this->extInvoiceRepository->createInvoiceItem($userPaymentCustomer, $amount, $description);

        return $this->extInvoiceRepository->createInvoice($userPaymentCustomer);
    }

    public function retryPaymentForUnpaidInvoice(User $user)
    {
        $UnpaidInvoices = $this->invoiceRepository->getAllUnpaidInvoicesByUser($user);
        return $UnpaidInvoices->each(function (Invoice $invoice) {
            $this->extInvoiceRepository->retryPaymentForInvoice($invoice);
        });
    }
}
