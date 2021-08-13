<?php

namespace Database\Seeders;

use Bachelor\Domain\PaymentManagement\PaymentProvider\Enum\PaymentGateway;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Interfaces\PaymentProviderRepositoryInterface;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentProvider\ModelDao\PaymentProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Seeder;

class PaymentProviderSeeder extends Seeder
{
    /*
     * PaymentProviderRepositoryInterface
     */
    private $paymentProviderRepository;

    /**
     * PaymentProviderSeeder constructor.
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->paymentProviderRepository = app()->make(PaymentProviderRepositoryInterface::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time_start = microtime(true);

        echo 'PaymentProviderSeeder started' . PHP_EOL;

        self::_seed();

        $time_end = microtime(true);

        Log::info('PaymentProviderSeeder finished | took ' . ($time_end - $time_start) . 's');
    }

    /**
     * Initiate the seeder
     */
    private function _seed()
    {
        foreach (PaymentGateway::getInstances() as $paymentGateway)
            self::_firstOrCreatePaymentProvider(self::_getFormattedData($paymentGateway));
    }

    /**
     * First or create payment provider
     *
     * @param array $data
     * @return PaymentProvider
     */
    private function _firstOrCreatePaymentProvider(array $data): PaymentProvider
    {
        return $this->paymentProviderRepository->firstOrCreate($data);
    }

    /**
     * Get formatted payment gateway data
     *
     * @param PaymentGateway $paymentGateway
     * @return array
     */
    private function _getFormattedData(PaymentGateway $paymentGateway): array
    {
        return [
            'name' => $paymentGateway->value
        ];
    }
}
