<?php

namespace Bachelor\Domain\PaymentManagement\Invoice\Interfaces;

use Bachelor\Domain\PaymentManagement\Invoice\Models\Invoice;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface InvoiceRepositoryInterface
{
    /**
     * @param User $user
     * @return Collection
     */
    public function getAllUnpaidInvoicesWhichGracePeriodExpiredByUser(User $user): Collection;

    /**
     * @param User $user
     * @return Collection
     */
    public function getAllUnpaidInvoicesByUser(User $user): Collection;

    /**
     * @param string|null $thirdPartyCustomerId
     * @return Invoice|null
     */
    public function getInvoiceByThirdPartyInvoiceId(?string $thirdPartyCustomerId): ?Invoice;

    /**
     * @return Collection
     */
    public function getAllUnpaidInvoicesWhichGracePeriodExpired(): Collection;

    /**
     * Create new invoice
     *
     * @param Invoice $invoice
     * @return mixed
     */
    public function save(Invoice $invoice): Invoice;
}
