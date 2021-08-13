<?php

namespace Bachelor\Domain\PaymentManagement\Plan\Enum;
use Bachelor\Utility\Enums\IntEnum;

/**
 */
final class ContractTerm extends IntEnum
{
    const OneMonth = 1;
    const ThreeMonth = 3;
    const SixMonth = 6;
    const TwelveMonth = 12;
}
