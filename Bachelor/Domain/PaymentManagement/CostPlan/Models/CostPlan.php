<?php

namespace Bachelor\Domain\PaymentManagement\CostPlan\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan as CostPlanKey;
use Illuminate\Validation\Rule;

class CostPlan extends BaseDomainModel
{
    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $rank;

    /**
     * @var array
     */
    private array $content = [
        'light' => [
            'name' => 'お手軽',
            'rank' => 10
        ],
        'normal' => [
            'name' => 'ベーシック',
            'rank' => 20
        ],
        'premium' => [
            'name' => 'プレミアム',
            'rank' => 30
        ]
    ];

    public function __construct(string $key)
    {
        $this->setKey($key);
        if (!empty($key)) {
            $this->name = $this->content[$key]['name'];
            $this->rank = $this->content[$key]['rank'];
        }
    }

    /**
     * Set the value of key
     *
     * @return string
     */
    public function setKey(string $key): void
    {
        $validator = validator([
            'cost_plan_key' => $key
        ], [
            'cost_plan_key' => [
                Rule::in(CostPlanKey::getValues())
            ]
        ]);
        if ($validator->fails()) {
            throw new BaseValidationException($validator);
        }

        $this->key = $key;
    }

    /**
     * Get the value of key
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Get the value of name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of rank
     *
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * Is upgrade or not
     *
     * @return bool
     */
    public function isUpgradeThan(CostPlan $anotherCostPlan): bool
    {
        return $this->rank > $anotherCostPlan->rank;
    }

    /**
     * Get the value of rank
     *
     * @return bool
     */
    public function isDowngradeThan(CostPlan $anotherCostPlan): bool
    {
        return $this->rank < $anotherCostPlan->rank;
    }
}
