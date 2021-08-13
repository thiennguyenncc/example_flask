<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Payment\Traits;

use Bachelor\Port\Secondary\Database\PaymentManagement\Invoice\ModelDao\Invoice;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\ModelDao\PaymentCard;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentProvider\ModelDao\PaymentProvider;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserPaymentProviderRelationshipTrait
{
    /**
     * Get information about the payment provider
     *
     * @return mixed
     */
    public function paymentProvider()
    {
        return $this->belongsTo(PaymentProvider::class);
    }

    /**
     * Get the user to which this payment data belongs to
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the payment card to which this payment data belongs to
     *
     * @return mixed
     */
    public function defaultPaymentCard()
    {
        return $this->belongsTo(PaymentCard::class, 'default_payment_card_id');
    }

    /**
     * Get user card
     *
     * @return mixed
     */
    public function paymentCards() :HasMany
    {
        return $this->hasMany(PaymentCard::class, 'id');
    }

    /**
     * Get user invoices
     *
     * @return mixed
     */
    public function invoices() :HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
