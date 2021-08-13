<?php

namespace Bachelor\Domain\PaymentManagement\PaymentCard\Service;

use Bachelor\Domain\PaymentManagement\PaymentCard\Interfaces\PaymentCardInterface;
use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Factories\PaymentProviderFactory;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Interfaces\PaymentProviderRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Factories\UserPaymentCustomerFactory;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\UserPaymentCustomerRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Services\UserPaymentCustomerService;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\Factory\PaymentCardFactory;

class PaymentCardService
{
    private PaymentCardInterface $paymentCardRepository;

    private UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository;

    /**
     * PaymentCardService constructor.
     * @param PaymentCardInterface $paymentCardRepository
     * @param UserPaymentCustomerFactory $userPaymentCustomerRepository
     */
    public function __construct(
        PaymentCardInterface $paymentCardRepository,
        UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository
    ) {
        $this->paymentCardRepository = $paymentCardRepository;
        $this->userPaymentCustomerRepository = $userPaymentCustomerRepository;
    }

    /**
     * @param PaymentCard $paymentCard
     * @return PaymentCard
     */
    public function saveData(PaymentCard $paymentCard): PaymentCard
    {
        return $this->paymentCardRepository->save($paymentCard);
    }
}
