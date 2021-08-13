<?php
namespace Bachelor\Port\Secondary\PaymentManagement\Stripe\Base;

use Stripe\Stripe;

class StripeBaseRepository
{
    /**
     * StripeBaseRepository constructor.
     * @param string $secret
     * @throws BindingResolutionException
     */
    public function __construct ()
    {
        Stripe::setApiKey(config('services.stripe.'.env('STRIPE_MODE').'.secret'));
    }
}
