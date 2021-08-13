<?php

namespace Bachelor\Domain\DatingManagement\RequestCancellationForm\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * ReasonForCancellation
 */
final class ReasonForCancellation extends IntEnum
{
    // Constants for cancel option in cancelled date by me api
    const BadHealthCondition = 10;
    const HavingUrgentBusiness = 20;
    const DissatisfactionToPartnersAge = 30;
    const DissatisfactionToPartnersIncome = 31;
    const DissatisfactionToPartnersJob = 32;
    const DissatisfactionToPartnersHeight = 33;
    const DissatisfactionToPartnerOther = 39;
    const Other = 99;
}
