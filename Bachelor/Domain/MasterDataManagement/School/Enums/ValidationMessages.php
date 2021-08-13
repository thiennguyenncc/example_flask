<?php

namespace Bachelor\Domain\MasterDataManagement\School\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static schoolDoesNotExist()
 */
final class ValidationMessages extends Enum
{
    const schoolDoesNotExist = [
        'schoolId' => ['学校は存在しません']
    ];
}
