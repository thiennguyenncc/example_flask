<?php

namespace Bachelor\Application\Admin\Traits;

use Carbon\Carbon;

trait ParticipantImportFormatter
{
    /**
     * Validate and format csv/excel imported data
     *
     * @param array $importedRawData
     * @return array[]
     */
    private function validateAndFormatImportData(array $importedRawData): array
    {
        $userIds = $this->getUserIds();
        $matchingDates = $this->getUpcomingMatchingDates();
        $matchingDays = array_keys($matchingDates);

        $valid = $invalid = [];
        foreach ($importedRawData as $row) {
            if (!in_array($row[0], $userIds)) {
                $invalid[] = [
                    'user_id' => $row[0],
                    'dating_day' => $row[1],
                    'reason' => __('admin_messages.user_not_found'),
                ];
            } else if (!in_array($row[1], $matchingDays)) {
                $invalid[] = [
                    'user_id' => $row[0],
                    'dating_day' => $row[1],
                    'reason' => __('admin_messages.dating_day_not_valid_or_created'),
                ];
            } else {
                $valid[$row[0]]['user_id'] = $row[0];
                $valid[$row[0]]['dating_dates'][] = [
                    'id' => $matchingDates[$row[1]]['id'],
                    'dating_day' => $matchingDates[$row[1]]['dating_day']
                ];
            }
        }
        return [
            'valid' => $valid,
            'invalid' => $invalid,
        ];
    }

    /**
     * Get user IDs
     *
     * @return array
     */
    private function getUserIds()
    {
        return array_map(function ($item) {
            return $item['id'];
        }, $this->user->retrieveUsers()->get('id')->toArray());
    }

    /**
     * Get upcoming match dating users
     *
     * @return array
     */
    private function getUpcomingMatchingDates()
    {
        $matchingDates = [];
        $allMatchingDates = $this->datingDay->getValidMatchingDates();
        foreach ($allMatchingDates as $validMatchingDate) {
            // remove duplicated day (get the upcoming day only)
            if (!isset($matchingDates[$validMatchingDate['dating_day']]) ||
                Carbon::parse($matchingDates[$validMatchingDate['dating_date']])->getTimestamp() > Carbon::parse($validMatchingDate['dating_date'])->getTimestamp()
            ) {
                $matchingDates[$validMatchingDate['dating_day']] = $validMatchingDate;
            }
        }
        return $matchingDates;
    }
}
