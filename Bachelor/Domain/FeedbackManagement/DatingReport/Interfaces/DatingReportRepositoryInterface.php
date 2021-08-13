<?php

namespace Bachelor\Domain\FeedbackManagement\DatingReport\Interfaces;

use Bachelor\Domain\FeedbackManagement\DatingReport\Models\DatingReport;
use Illuminate\Database\Eloquent\Model as ModelDAO;
use Illuminate\Support\Collection;

interface DatingReportRepositoryInterface
{
    /**
     * @param $userId
     * @return ?DatingReport
     */
    public function getLastDatingReportOfUser($userId): ?DatingReport;

    /**
     * Save dating report
     *
     * @param $userId
     * @param $datingReportData
     * @param $reviewCount
     * @param $feedbackIds
     * @param $displayDatingReportTime
     */
    public function saveDatingReport(DatingReport $datingReport):DatingReport;

    /**
     * @param array $userIds
     * @return Collection
     */
    public function getReportsByUserIds(array $userIds): Collection;

    /**
     * Get list user id that updated dating report
     *
     * @param array $userIds
     * @return array
     */
    public function getUserIdsReportDisplayDateToday(array $userIds = []): array;

    /**
     * Get feedback number of last dating report by user ids
     *
     * @param array $userIds
     * @return array
     */
    public function getFeedbackNumbersOfDatingReportByUserIds(array $userIds): array;

    /**
     * @param integer $userId
     * @param integer $datingId
     * @return Collection
     */
    public function getDatingReportsByUserIdNDatingId(int $userId, int $datingId): Collection;
}
