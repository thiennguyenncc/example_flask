<?php
namespace Bachelor\Domain\Base\Exception;

use BenSampo\Enum\Enum;

final class BaseValidationMessages extends Enum
{
    // TODO update correct japanese word
    const InvalidStatus = [
        'invalid_status' => ['ステータスが無効です']
    ];
    const UserInapproved = [
        'status_inapproved' => ['審査合格済みではありません。']
    ];
}
