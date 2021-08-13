<?php

namespace Bachelor\Domain\DatingManagement\Dating\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\RequestCancellationForm\Enums\ReasonForCancellation;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/**
 * @method int getId()
 * @method void setId(int $id)
 * @method int getDatingUserId()
 * @method void setDatingUserId(int $datingUser)
 * @method array getReasonForCancellation()
 * @method void setReasonForCancellation(array $reasonForCancellation)
 * @method string getReasonForCancellationOtherText()
 * @method void setReasonForCancellationOtherText(string $reasonForCancellationOtherText)
 * @method string getReasonForCancellationDissatisfactionOtherText()
 * @method void setReasonForCancellationDissatisfactionOtherText(string $reasonForCancellationDissatisfactionOtherText)
 * @method string getDetailedReason()
 * @method void setDetailedReason(string $detailedReason)
 */
class DatingUserCancellForm extends BaseDomainModel
{
    /**
     * @var int
     */
    private int $datingUser;

    /**
     * @var array
     */
    private array $reasonForCancellation = [];

    /**
     * @var string|null
     */
    private ?string $reasonForCancellationOtherText = "";

    /**
     * @var string|null
     */
    private ?string $reasonForCancellationDissatisfactionOtherText = "";

    /**
     * @var string|null
     */
    private ?string $detailedReason = "";

    /**
     * DatingUserCancellForm constructor.
     *
     * @param integer $datingUser
     * @param array $reasonForCancellation
     * @param string|null $reasonForCancellationOtherText
     * @param string|null $reasonForCancellationDissatisfactionOtherText
     * @param string|null $detailedReason
     */
    public function __construct(
        int $datingUser,
        array $reasonForCancellation = [],
        ?string $reasonForCancellationOtherText = "",
        ?string $reasonForCancellationDissatisfactionOtherText = "",
        ?string $detailedReason = ""
    )
    {
        $this->setDatingUserId($datingUser);
        $this->setReasonForCancellation($reasonForCancellation);
        $this->setReasonForCancellationOtherText($reasonForCancellationOtherText);
        $this->setReasonForCancellationDissatisfactionOtherText($reasonForCancellationDissatisfactionOtherText);
        $this->setDetailedReason($detailedReason);
    }

    /**
     * Get the value of datingUser
     *
     * @return  int
     */
    public function getDatingUserId() :int
    {
        return $this->datingUser;
    }

    /**
     * Set the value of datingUser
     *
     * @param  int  $datingUser
     * @return void
     */
    public function setDatingUserId(int $datingUser) :void
    {
        $this->datingUser = $datingUser;
    }

    /**
     * Get the value of reasonForCancellation
     *
     * @return  array
     */
    public function getReasonForCancellation() :array
    {
        return $this->reasonForCancellation;
    }

    /**
     * @param array $reasonForCancellation
     */
    public function setReasonForCancellation(array $reasonForCancellation = []) :void
    {
        $validator = validator([
                'reasonForCancellation' => $reasonForCancellation
            ],[
                'reasonForCancellation.*' => [
                    Rule::in(ReasonForCancellation::getValues())
                ]
            ]
        );
        if($validator->fails()) {
            throw new ValidationException($validator);
        }
        $this->reasonForCancellation = $reasonForCancellation;
    }

    /**
     * Get the value of reasonForCancellationOtherText
     *
     * @return  string|null
     */
    public function getReasonForCancellationOtherText() :?string
    {
        return $this->reasonForCancellationOtherText;
    }

    /**
     * Set the value of reasonForCancellationOtherText
     *
     * @param  string|null  $reasonForCancellationOtherText
     * @return void
     */
    public function setReasonForCancellationOtherText(?string $reasonForCancellationOtherText = "") :void
    {
        $this->reasonForCancellationOtherText = $reasonForCancellationOtherText;
    }

    /**
     * Get the value of reasonForCancellationDissatisfactionOtherText
     *
     * @return  string|null
     */
    public function getReasonForCancellationDissatisfactionOtherText() :?string
    {
        return $this->reasonForCancellationDissatisfactionOtherText;
    }

    /**
     * Set the value of reasonForCancellationDissatisfactionOtherText
     *
     * @param  string|null  $reasonForCancellationDissatisfactionOtherText
     * @return void
     */
    public function setReasonForCancellationDissatisfactionOtherText(?string $reasonForCancellationDissatisfactionOtherText = "") :void
    {
        $this->reasonForCancellationDissatisfactionOtherText = $reasonForCancellationDissatisfactionOtherText;
    }

    /**
     * Get the value of detailedReason
     *
     * @return  string|null
     */
    public function getDetailedReason() :?string
    {
        return $this->detailedReason;
    }

    /**
     * Set the value of detailedReason
     *
     * @param  string|null  $detailedReason
     * @return void
     */
    public function setDetailedReason(?string $detailedReason = "") :void
    {
        $this->detailedReason = $detailedReason;
    }
}
