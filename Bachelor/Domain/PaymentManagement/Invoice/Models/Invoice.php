<?php

namespace Bachelor\Domain\PaymentManagement\Invoice\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\Invoice\Enum\InvoiceStatus;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class Invoice extends BaseDomainModel
{
    /**
     * @var UserPaymentCustomer
     */
    private UserPaymentCustomer $userPaymentCard;

    /**
     * @var Collection|null
     */
    private ?Collection $invoiceItems;

    /**
     * @var string
     */
    private ?string $description;

    /**
     * @var int
     */
    private ?int $subscriptionId;

    /**
     * @var int
     */
    private int $status = InvoiceStatus::Draft;

    /**
     * @var bool
     */
    private bool $autoAdvance = true;

    /**
     * @var string
     */
    private string $thirdPartyInvoiceId;

    /**
     * @var string|null
     */
    private ?string $hostedInvoiceUrl = null;

    /**
     * @var Carbon|null
     */
    private ?Carbon $gracePeriodStartsAt = null;

    /**
     * @var Carbon|null
     */
    private ?Carbon $gracePeriodEndsAt = null;

    /**
     * Invoice constructor.
     * @param UserPaymentCustomer $userPaymentCustomer
     * @param Charge $charge
     * @param int $subscriptionId
     */
    public function __construct(
        UserPaymentCustomer $userPaymentCustomer,
        string $thirdPartyInvoiceId,
        Collection $invoiceItems = null,
        string $description = "",
        ?int $subscriptionId =  null,
        int $status =  InvoiceStatus::Draft,
        bool $autoAdvance =  true,
        ?string $hostedInvoiceUrl = null,
        ?Carbon $gracePeriodStartsAt = null,
        ?Carbon $gracePeriodEndsAt = null
    ) {
        $this->setUserPaymentCustomer($userPaymentCustomer);
        $this->setThirdPartyInvoiceId($thirdPartyInvoiceId);
        $this->setSubscriptionId($subscriptionId);
        $this->setInvoiceItems($invoiceItems);
        $this->setDescription($description);
        $this->setStatus($status);
        $this->setAutoAdvance($autoAdvance);
        $this->setHostedInvoiceUrl($hostedInvoiceUrl);
        $this->setGracePeriodStartsAt($gracePeriodStartsAt);
        $this->setGracePeriodEndsAt($gracePeriodEndsAt);
    }

    /**
     * @param int|null $subscriptionId
     */
    public function updateStatus(int $status): void
    {
        if ($status === InvoiceStatus::Open && $this->status !== InvoiceStatus::Open) {
            $this->setGracePeriodStartsAt(Carbon::now());
            $this->setGracePeriodEndsAt(Carbon::now()->addMonth());
        }
        $this->setStatus($status);
    }

    /**
     * @return int|null
     */
    public function getSubscriptionId(): ?int
    {
        return $this->subscriptionId;
    }

    /**
     * @param int|null $subscriptionId
     */
    public function setSubscriptionId(?int $subscriptionId): void
    {
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * @return Collection
     */
    public function getInvoiceItems(): Collection
    {
        return $this->invoiceItems;
    }

    /**
     * @param Collection $charge
     */
    public function setInvoiceItems(Collection $invoiceItems): void
    {
        $this->invoiceItems = $invoiceItems;
    }

    /**
     * @return UserPaymentCustomer
     */
    public function getUserPaymentCustomer(): UserPaymentCustomer
    {
        return $this->userPaymentCard;
    }

    /**
     * @param UserPaymentCustomer $userPaymentCard
     */
    public function setUserPaymentCustomer(UserPaymentCustomer $userPaymentCard): void
    {
        $this->userPaymentCard = $userPaymentCard;
    }


    /**
     * @return  int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param  int  $status
     */
    public function setStatus(int $status): void
    {
        $validator = validator(
            ['status' => $status],
            [
                'status' => [Rule::in(InvoiceStatus::getValues())]
            ]
        );

        if ($validator->fails()) throw new ValidationException($validator);

        $this->status = $status;
    }

    /**
     * @return  bool
     */
    public function getAutoAdvance(): bool
    {
        return $this->autoAdvance;
    }

    /**
     * @param  bool  $autoAdvance
     */
    public function setAutoAdvance(bool $autoAdvance): void
    {
        $this->autoAdvance = $autoAdvance;
    }

    /**
     * @return  string
     */
    public function getThirdPartyInvoiceId(): string
    {
        return $this->thirdPartyInvoiceId;
    }

    /**
     * @param  string  $thirdPartyInvoiceId
     */
    public function setThirdPartyInvoiceId(string $thirdPartyInvoiceId): void
    {
        $this->thirdPartyInvoiceId = $thirdPartyInvoiceId;
    }

    /**
     * Get description
     *
     * @return  string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param  string  $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description ?: __('api_messages.stripe_api.cancellation_fee_invoice_memo.' . App::getLocale());
    }

    /**
     * Get the value of hostedInvoiceUrl
     *
     * @return  string|null
     */
    public function getHostedInvoiceUrl(): ?string
    {
        return $this->hostedInvoiceUrl;
    }

    /**
     * Set the value of hostedInvoiceUrl
     *
     * @param  string|null  $hostedInvoiceUrl
     */
    public function setHostedInvoiceUrl(?string $hostedInvoiceUrl = null): void
    {
        $this->hostedInvoiceUrl = $hostedInvoiceUrl;
    }

    /**
     * Get the value of gracePeriodStartsAt
     *
     * @return  Carbon|null
     */
    public function getGracePeriodStartsAt(): ?Carbon
    {
        return $this->gracePeriodStartsAt;
    }

    /**
     * Set the value of gracePeriodStartsAt
     *
     * @param  Carbon|null  $gracePeriodStartsAt
     */
    private function setGracePeriodStartsAt(?Carbon $gracePeriodStartsAt = null): void
    {
        $this->gracePeriodStartsAt = $gracePeriodStartsAt;
    }

    /**
     * Get the value of gracePeriodEndsAt
     *
     * @return  Carbon|null
     */
    public function getGracePeriodEndsAt(): ?Carbon
    {
        return $this->gracePeriodEndsAt;
    }

    /**
     * Set the value of gracePeriodEndsAt
     *
     * @param  Carbon|null  $gracePeriodEndsAt
     */
    private function setGracePeriodEndsAt(?Carbon $gracePeriodEndsAt = null): void
    {
        $this->gracePeriodEndsAt = $gracePeriodEndsAt;
    }
}
