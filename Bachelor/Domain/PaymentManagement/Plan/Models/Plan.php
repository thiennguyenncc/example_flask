<?php

namespace Bachelor\Domain\PaymentManagement\Plan\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan as CostPlanEnum;
use Bachelor\Domain\PaymentManagement\CostPlan\Models\CostPlan;
use Bachelor\Domain\PaymentManagement\Plan\Enum\DiscountType;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class Plan extends BaseDomainModel
{
    /**
     * @var int
     */
    private string $thirdPartyPlanId;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private string $nickname;

    /**
     * @var string
     */
    private string $discountType;

    /**
     * @var string
     */
    private string $costPlanKey;

    /**
     * @var int
     */
    private int $contractTerm;

    /**
     * @var int
     */
    private int $finalAmount;

    /**
     * @var Carbon
     */
    private Carbon $updatedAt;

    /**
     * @var CostPlan|null
     */
    private ?CostPlan $costPlan = null;


    /**
     * Plan constructor.
     * @param int $thirdPartyPlanId
     * @param string $name
     * @param string $costPlanKey
     * @param int $finalAmount
     */
    public function __construct(string $thirdPartyPlanId, string $name, string $nickname, string $discountType, string $costPlanKey, int $contractTerm, int $finalAmount)
    {
        $this->setThirdPartyPlanId($thirdPartyPlanId);
        $this->setName($name);
        $this->setNickname($nickname);
        $this->setDiscountType($discountType);
        $this->setCostPlanKey($costPlanKey);
        $this->setContractTerm($contractTerm);
        $this->setFinalAmount($finalAmount);
        $this->setCostPlanByKey();
    }

    /**
     * @return string
     */
    public function getThirdPartyPlanId(): string
    {
        return $this->thirdPartyPlanId;
    }

    /**
     * @param int $thirdPartyPlanId
     */
    public function setThirdPartyPlanId(string $thirdPartyPlanId): void
    {
        $this->thirdPartyPlanId = $thirdPartyPlanId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCostPlanKey(): string
    {
        return $this->costPlanKey;
    }

    /**
     * @param string $costPlan
     */
    public function setCostPlanKey(string $costPlanKey): void
    {
        $validator = validator([
            'cost_plan' => $costPlanKey
        ], [
            'cost_plan' => [
                Rule::in(CostPlanEnum::getValues())
            ]
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $this->costPlanKey = $costPlanKey;
    }

    /**
     * @return int
     */
    public function getFinalAmount(): int
    {
        return $this->finalAmount;
    }

    /**
     * @param int $finalAmount
     */
    public function setFinalAmount(int $finalAmount): void
    {
        $this->finalAmount = $finalAmount;
    }

    /**
     * @return  string
     */
    public function getDiscountType(): string
    {
        return $this->discountType;
    }

    /**
     * @param  string  $discountType
     */
    public function setDiscountType(string $discountType): void
    {
        $validator = validator([
            'discount_type' => $discountType
        ], [
            'discount_type' => [
                Rule::in(DiscountType::getValues())
            ]
        ]);
        if ($validator->fails()) {
            throw new BaseValidationException($validator);
        }
        $this->discountType = $discountType;
    }

    /**
     * @return  int
     */
    public function getContractTerm(): int
    {
        return $this->contractTerm;
    }

    /**
     * @param  int  $contractTerm
     *
     */
    public function setContractTerm(int $contractTerm): void
    {
        $this->contractTerm = $contractTerm;
    }

    /**
     * Get the value of nickname
     *
     * @return  string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * Set the value of nickname
     *
     * @param  string  $nickname
     */
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return float
     */
    public function getAmountPerDating(): float
    {
        return round($this->getFinalAmount() / 4, -1);
    }

    /**
     * @return void
     */
    private function setCostPlanByKey(): void
    {
        $this->costPlan = new CostPlan($this->costPlanKey);
    }

    /**
     * @return CostPlan
     */
    public function getCostPlan(): CostPlan
    {
        return $this->costPlan;
    }

    /**
     * @param Carbon $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }
}
