<?php

namespace Bachelor\Domain\PaymentManagement\PaymentCard\Enum;

use BenSampo\Enum\Enum;

/**
 * @method static InvalidCard()
 * @method static CannotDeletePrimaryCard()
 */
final class ValidationMessages extends Enum
{
    const InvalidCard = [
        'invalid_card' => ['カードが不正です']
    ];
    const CannotDeletePrimaryCard = [
        'cannot_delete_primary_card' => ['支払いカードは削除できません']
    ];
}
