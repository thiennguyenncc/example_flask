<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Invoice\Repository;

use Bachelor\Domain\PaymentManagement\Invoice\Enum\InvoiceStatus;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Models\Invoice as InvoiceDomainEntity;
use Bachelor\Domain\PaymentManagement\Invoice\Models\InvoiceItem as InvoiceItemDomainEntity;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\Invoice\ModelDao\Invoice;
use Bachelor\Port\Secondary\Database\PaymentManagement\Invoice\ModelDao\InvoiceItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EloquentInvoiceRepository extends EloquentBaseRepository implements InvoiceRepositoryInterface
{
    private InvoiceItem $invoiceItemDao;
    /**
     * EloquentInvoiceRepository constructor.
     * @param Invoice $model
     * @param InvoiceItem $invoiceItemDao
     */
    public function __construct(Invoice $model, InvoiceItem $invoiceItemDao)
    {
        parent::__construct($model);
        $this->invoiceItemDao = $invoiceItemDao;
    }


    /**
     * @param InvoiceDomainEntity $invoice
     * @return InvoiceDomainEntity
     */
    public function save(InvoiceDomainEntity $invoice): InvoiceDomainEntity
    {
        $invoice = $this->createModelDAO($invoice->getId())->saveData($invoice);
        if ($invoice->getInvoiceItems()->isNotEmpty()) {
            $invoice->getInvoiceItems()->each(function (InvoiceItemDomainEntity $invoiceItem) use ($invoice) {
                $invoiceItem->setInvoiceId($invoice->getId());
                $this->invoiceItemDao->saveData($invoiceItem);
            });
        }

        return $invoice;
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getAllUnpaidInvoicesWhichGracePeriodExpiredByUser(User $user): Collection
    {
        if (!$user->getUserPaymentCustomer()) return collect();

        $invoices = $this->modelDAO->newModelQuery()
            ->where('user_payment_customer_id', $user->getUserPaymentCustomer()->getId())
            ->where('grace_period_ends_at', '<', Carbon::now())
            ->whereIn('status', InvoiceStatus::UnpaidStatuses())
            ->get();

        return $this->transformCollection($invoices);
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getAllUnpaidInvoicesByUser(User $user): Collection
    {
        if (!$user->getUserPaymentCustomer()) return collect();

        $invoices = $this->modelDAO->newModelQuery()
            ->where('user_payment_customer_id', $user->getUserPaymentCustomer()->getId())
            ->whereIn('status', InvoiceStatus::UnpaidStatuses())
            ->get();
        return $this->transformCollection($invoices);
    }

    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return Collection
     */
    public function getAllUnpaidInvoicesWhichGracePeriodExpired(): Collection
    {
        $invoices = $this->modelDAO->newModelQuery()
            ->whereIn('status', InvoiceStatus::UnpaidStatuses())
            ->where('grace_period_ends_at', '<', Carbon::now())
            ->get();

        return $this->transformCollection($invoices);
    }

    /**
     * @param string|null $thirdPartyCustomerId
     * @return InvoiceDomainEntity|null
     */
    public function getInvoiceByThirdPartyInvoiceId(?string $thirdPartyCustomerId): ?InvoiceDomainEntity
    {
        return optional($this->createModelDAO()->where('third_party_invoice_id', $thirdPartyCustomerId)->first())->toDomainEntity();
    }
}
