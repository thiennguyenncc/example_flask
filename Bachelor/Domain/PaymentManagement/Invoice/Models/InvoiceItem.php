<?php

namespace Bachelor\Domain\PaymentManagement\Invoice\Models;

use Bachelor\Domain\Base\BaseDomainModel;

class InvoiceItem extends BaseDomainModel
{
    /*
     * @var int
     */
    private ?int $invoiceId;

    /*
     * @var string
     */
    private ?string $description = "";

    /*
     * @var int|null
     */
    private int $amount;

    /**
     * InvoiceItem constructor.
     * @param int $amount
     * @param int $invoiceId
     */
    public function __construct (
        int $amount,
        string $description = "",
        ?int $invoiceId = null
        )
    {
        $this->setInvoiceId($invoiceId);
        $this->setDescription($description);
        $this->setAmount($amount);
    }

    /**
     * @return int|null
     */
    public function getInvoiceId (): ?int
    {
        return $this->invoiceId;
    }

    /**
     * @param int|null $invoiceId
     */
    public function setInvoiceId ( ?int $invoiceId = null ): void
    {
        $this->invoiceId = $invoiceId;
    }

    /**
     * @return int
     */
    public function getAmount (): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount ( int $amount ): void
    {
        $this->amount = $amount;
    }


    /**
     * Get description
     *
     * @return  string|null
     */
    public function getDescription() :string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param  string|null  $description
     */
    public function setDescription(string $description = "")
    {

        $this->description = $description;
    }
}
