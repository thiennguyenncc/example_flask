<?php

namespace Bachelor\Domain\PaymentManagement\PaymentProvider\Models;

use Bachelor\Domain\Base\BaseDomainModel;

class PaymentProvider extends BaseDomainModel
{
    /*
     * @var string
     */
    private ?string $name;

    /**
     * PaymentProvider constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
