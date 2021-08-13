<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Invoice\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\Invoice\Models\InvoiceItem as InvoiceItemDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_items';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity ()
    {
        $model = new InvoiceItemDomainEntity(
            $this->amount,
            $this->description,
            $this->invoice_id
        );

        $model->setId($this->getKey());

        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     * @return Invoice
     */
    protected function fromDomainEntity ( BaseDomainModel $model )
    {
        $this->id = $model->getId();
        $this->amount = $model->getAmount();
        $this->description = $model->getDescription();
        $this->invoice_id = $model->getInvoiceId();

        return $this;
    }

    /**
     * @return BelongsTo
     */
    protected function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
