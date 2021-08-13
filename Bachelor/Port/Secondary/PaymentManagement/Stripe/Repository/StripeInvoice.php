<?php

namespace Bachelor\Port\Secondary\PaymentManagement\Stripe\Repository;

use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\ExtInvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Models\Invoice;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Port\Secondary\PaymentManagement\Stripe\Base\StripeBaseRepository;
use Exception;
use Illuminate\Support\Facades\App;
use Stripe\Exception\ApiErrorException;

class StripeInvoice extends StripeBaseRepository  implements ExtInvoiceRepositoryInterface
{

    /**
     * Create Invoice
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @param int $amount
     * @param string $description
     * @throws ApiErrorException
     * @throws Exception
     */
    public function createInvoiceItem(UserPaymentCustomer $userPaymentCustomer, int $amount, string $description): bool
    {
        $invoiceItemPayload = [
            'customer' => $userPaymentCustomer->getThirdPartyCustomerId(),
            'amount' => $amount,
            'description' => $description,
            'currency' => config('constants.currency.' . App::getLocale())
        ];

        return (bool) \Stripe\InvoiceItem::create($invoiceItemPayload);
    }

    /**
     * Create Invoice and Invoice Item
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @return string
     * @throws ApiErrorException
     * @throws Exception
     */
    public function createInvoice(UserPaymentCustomer $userPaymentCustomer): string
    {
        $invoicePayload = [
            'customer' => $userPaymentCustomer->getThirdPartyCustomerId(),
            'description' => __('api_messages.stripe_api.cancellation_fee_invoice_memo.' . App::getLocale()),
            'auto_advance' => true
        ];
        return \Stripe\Invoice::create($invoicePayload)->id;
    }

    /**
     * retry payment for invoice
     *
     * @param Invoice $invoice
     * @throws ApiErrorException
     * @throws Exception
     */
    public function retryPaymentForInvoice(Invoice $invoice): bool
    {

        $invoice = \Stripe\Invoice::retrieve($invoice->getThirdPartyInvoiceId());

        return (bool) $invoice->pay();
    }
}
