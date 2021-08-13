<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Invoice\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\Invoice\Models\Invoice as InvoiceDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\PaymentManagement\Subscription\ModelDao\Subscription;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\ModelDao\UserPaymentCustomer;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Invoice extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoices';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity()
    {
        $model = new InvoiceDomainEntity(
            $this->userPaymentCustomer()->first()->toDomainEntity(),
            $this->third_party_invoice_id,
            $this->invoiceItems()->get()->transform(function (InvoiceItem $invoiceItem) {
                return $invoiceItem->toDomainEntity();
            }),
            $this->description,
            $this->subscription_id,
            $this->status,
            $this->auto_advance,
            $this->hosted_invoice_url,
            Carbon::make($this->grace_period_starts_at),
            Carbon::make($this->grace_period_ends_at)
        );

        $model->setId($this->getKey());

        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     * @return Invoice
     */
    protected function fromDomainEntity(BaseDomainModel $model)
    {
        $this->id = $model->getId();
        $this->user_payment_customer_id = $model->getUserPaymentCustomer()->getId();
        $this->description = $model->getDescription();
        $this->subscription_id = $model->getSubscriptionId();
        $this->status = $model->getStatus();
        $this->auto_advance = $model->getAutoAdvance();
        $this->third_party_invoice_id = $model->getThirdPartyInvoiceId();
        $this->hosted_invoice_url = $model->getHostedInvoiceUrl();
        $this->grace_period_starts_at = $model->getGracePeriodStartsAt();
        $this->grace_period_ends_at = $model->getGracePeriodEndsAt();

        return $this;
    }

    /**
     * @return BelongsTo
     */
    protected function userPaymentCustomer()
    {
        return $this->belongsTo(UserPaymentCustomer::class);
    }

    /**
     * @return HasOneThrough
     */
    protected function user()
    {
        return $this->hasOneThrough(User::class, Subscription::class);
    }

    /**
     * @return HasMany
     */
    protected function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
