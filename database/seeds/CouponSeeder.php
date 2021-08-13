<?php

namespace Database\Seeders;

use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\MasterDataManagement\Coupon\Interfaces\CouponRepositoryInterface;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\ModelDao\Coupon;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{

    private $couponRepository;

    /**
     * LanguageSeeder constructor.
     * @throws BindingResolutionException
     */
    public function __construct ()
    {
        $this->couponRepository = app()->make(CouponRepositoryInterface::class);
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time_start = microtime(true);
        $this->_seed();
        $time_end = microtime(true);
        Log::info('CouponSeeder finished | took ' . ($time_end - $time_start) . 's');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function _seed()
    {
        $seeds = [
            [
                'name' => 'dating',
                'coupon_type' => CouponType::Dating
            ],
            [
                'name' => 'bachelor_coupon',
                'coupon_type' => CouponType::Bachelor
            ]
        ];

        foreach ($seeds as $data) {
            $this->couponRepository->firstOrCreate($data);
        }

    }
}
