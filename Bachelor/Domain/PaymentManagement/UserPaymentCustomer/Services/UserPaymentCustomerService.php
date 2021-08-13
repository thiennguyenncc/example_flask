<?php

namespace Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Services;

use Bachelor\Domain\PaymentManagement\PaymentCard\Interfaces\PaymentCardInterface;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Interfaces\PaymentProviderRepositoryInterface;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Models\PaymentProvider;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\UserPaymentCustomerRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Exception;

class UserPaymentCustomerService
{
    /**
     * @var UserPaymentCustomerRepositoryInterface
     */
    private UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository;

    private UserRepositoryInterface $userRepository;

    private PaymentProviderRepositoryInterface $paymentProviderRepository;

    private PaymentCardInterface $paymentCardRepository;

    /**
     * UserPaymentCustomerService constructor.
     * @param UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository
     */
    public function __construct(
        UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository,
        UserRepositoryInterface $userRepository,
        PaymentProviderRepositoryInterface $paymentProviderRepository,
        PaymentCardInterface $paymentCardRepository
    ) {
        $this->userPaymentCustomerRepository = $userPaymentCustomerRepository;
        $this->userRepository = $userRepository;
        $this->paymentProviderRepository = $paymentProviderRepository;
        $this->paymentCardRepository = $paymentCardRepository;
    }

    public function getUserByThirdPartyCustomerId(string $thirdPartyCustomerId): User
    {
        $userPaymentCustomer = $this->userPaymentCustomerRepository->getUserPaymentCustomerByThirdPartyId($thirdPartyCustomerId);
        if ($userPaymentCustomer) {
            return $this->userRepository->getById($userPaymentCustomer->getUserId());
        }
        throw new Exception(__('api_messages.user_payment_customer_not_found'));
    }
}
