<?php

namespace Bachelor\Domain\DatingManagement\Dating\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static BadHealthCondition()
 * @method static HavingUrgentBusiness()
 * @method static DissatisfactionToPartnersAge()
 * @method static DissatisfactionToPartnersIncome()
 * @method static DissatisfactionToPartnersJob()
 * @method static DissatisfactionToPartnersHeight()
 * @method static DissatisfactionToPartnerOther()
 * @method static Other()
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
