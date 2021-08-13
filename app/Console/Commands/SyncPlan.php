<?php

namespace App\Console\Commands;

use Bachelor\Domain\Base\TimeSetting\Services\TimeSettingService;
use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Plan\Models\Plan as ModelsPlan;
use Illuminate\Support\Str;
use Stripe\Plan;
use Stripe\Product;

class SyncPlan extends BachelorBaseCommand
{
    private PlanRepositoryInterface $planRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:sync-from-third-party';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'refresh plan table by get from stripe';

    public function __construct(PlanRepositoryInterface $planRepository)
    {
        parent::__construct();
        $this->planRepository = $planRepository;
    }

    /**
     * Execute the console command.
     *
     * @param TimeSettingService $timeSettingService
     */
    public function handle()
    {

        $plans = Plan::all(["limit" => 100]);
        $this->handlePlansMigrated($plans->data);

        while ($plans->has_more) {
            $this->handlePlansMigrated($plans->data);
            $plans = $plans->nextPage();
        }

        $this->info('done');
    }

    /**
     * Handle migrate Plans from Stripe
     *
     * @param array $stripePlansObject
     * @return void
     * @throws ApiErrorException
     */
    private function handlePlansMigrated(array $stripePlansObject): void
    {
        $plans = [];
        foreach ($stripePlansObject as $stripePlan) {
            $product = Product::retrieve($stripePlan['product']);
            $costPlan = $this->getCostPlanKeyByStripePlanName(strtolower($product->name));

            $plan = $this->planRepository->getPlanByThirdPartyPlanId($stripePlan['id']);
            if ($plan) {
                $plan->setName($product ? $product->name : "");
                $plan->setNickname($stripePlan['nickname'] ?? "");
                $plan->setDiscountType($stripePlan['metadata']['discount_type'] ?? "");
                $plan->setCostPlanKey($stripePlan['metadata']['cost_plan'] ?? $costPlan);
                $plan->setContractTerm($stripePlan['metadata']['contract_term'] ?? 1);
                $plan->setFinalAmount($stripePlan['amount']);
                array_push($plans, $plan);
            } else {
                array_push($plans, new ModelsPlan(
                    $stripePlan['id'],
                    $product ? $product->name : "",
                    $stripePlan['nickname'] ?? "",
                    $stripePlan['metadata']['discount_type'] ?? "",
                    $stripePlan['metadata']['cost_plan'] ?? $costPlan,
                    $stripePlan['metadata']['contract_term'] ?? 1,
                    $stripePlan['amount']
                ));
            }
        }

        $this->planRepository->saveAll(collect($plans));
    }

    /**
     * @param string $name
     * @return string|null
     */
    private function getCostPlanKeyByStripePlanName(string $name): string|null
    {
        return match (true) {
            Str::contains($name, ['プレミアム', 'premium']) => CostPlan::Premium,
            Str::contains($name, ['ベーシック', 'normal']) => CostPlan::Normal,
            Str::contains($name, ['お手軽', 'light']) => CostPlan::Light,
            default => null,
        };
    }
}
