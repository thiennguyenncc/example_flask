<?php

namespace Database\Seeders;

use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\PaymentManagement\Plan\Enum\DiscountType;
use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    private PlanRepositoryInterface $planRepository;

    /**
     * LanguageSeeder constructor.
     * @throws BindingResolutionException
     */
    public function __construct(PlanRepositoryInterface $planRepository)
    {
        $this->planRepository = $planRepository;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeds = [
            [
                'name' => 'プレミアムプラン (Premium Plan) No trial',
                'nickname' => 'プレミアムプラン (Premium Plan) No trial',
                'third_party_plan_id' => 'plan_Eys1YnwfQqz1Tt',
                'discount_type' => DiscountType::NoDiscount,
                'cost_plan' => CostPlan::Premium,
                'final_amount' => '29800',

            ], [
                'name' => 'ベーシックプラン (Normal Plan) No trial',
                'nickname' => 'ベーシックプラン (Normal Plan) No trial',
                'third_party_plan_id' => 'male-4t',
                'discount_type' => DiscountType::NoDiscount,
                'cost_plan' => CostPlan::Normal,
                'final_amount' => '19800',
            ], [
                'name' => '旧お手軽プラン (Light Plan) No trial',
                'nickname' => '旧お手軽プラン (Light Plan) No trial',
                'third_party_plan_id' => 'plan_Eys2dXiZ4ADlCW',
                'discount_type' => DiscountType::NoDiscount,
                'cost_plan' => CostPlan::Light,
                'final_amount' => '12800',
            ]
        ];

        foreach ($seeds as $data) {
            $this->planRepository->firstOrCreate($data);
        }
    }
}
