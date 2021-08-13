<?php

namespace Bachelor\Application\User\Services\Interfaces;

use Bachelor\Domain\UserManagement\User\Models\User;

interface DatingReportServiceInterface
{
    /**
     * @param User $user
     * @param $datingReportId
     * @return array
     */
    public function getDatingReportInfo(User $user, $datingReportId): array;

    /**
     * @param User $user
     * @return bool
     */
    public function checkShowPopup(User $user): bool;

}
