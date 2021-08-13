<?php


namespace Bachelor\Domain\UserManagement\User\Enums;


use MyCLabs\Enum\Enum;

final class ImportApprovalStatus extends Enum
{
    const Approved = "TRUE";
    const UnApproved = "FALSE";
}
