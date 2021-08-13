<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\Factories;

use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;

class PaymentCardFactory
{
    /**
     * @param UserPaymentCustomer $userPaymentCustomer
     * @param string $thirdPartyCardId
     * @param string $lastFourDigits
     * @return PaymentCard
     */
    public function createPaymentCard(UserPaymentCustomer $userPaymentCustomer, string $thirdPartyCardId, string $lastFourDigits)
    {
        return new PaymentCard($userPaymentCustomer->getId(), $thirdPartyCardId, $lastFourDigits);
    }
}
