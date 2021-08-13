<?php

namespace Bachelor\Domain\PaymentManagement\Invoice\Interfaces;

use Bachelor\Domain\PaymentManagement\Invoice\Models\Invoice;
use Bachelor\Domain\PaymentManagement\Invoice\Models\InvoiceItem;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Stripe\Exception\ApiErrorException;

interface ExtInvoiceRepositoryInterface
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
    public function createInvoiceItem(UserPaymentCustomer $userPaymentCustomer, int $amount, string $description): bool;

    /**
     * Create Invoice and Invoice Item
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @return string
     * @throws ApiErrorException
     * @throws Exception
     */
    public function createInvoice(UserPaymentCustomer $userPaymentCustomer): string;

    /**
     * retry payment for invoice
     *
     * @param Invoice $invoice
     * @throws ApiErrorException
     * @throws Exception
     */
    public function retryPaymentForInvoice(Invoice $invoice): bool;
}
