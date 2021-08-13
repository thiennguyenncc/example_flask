<?php

namespace Bachelor\Application\Admin\Traits;

use Bachelor\Domain\DatingManagement\Matching\Enums\RematchingType;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Carbon\Carbon;

trait RematchingImportFormatter
{
    /**
     * Validate & format imported csv raw data
     *
     * @param array $importedRawData
     * @return array [ 'valid' => [], 'invalid' => [] ]
     */
    private function validateAndFormatImportData(array $importedRawData): array
    {
        $userIds = $this->getUserIds();
        $validTypes = RematchingType::asArray();

        $valid = $invalid = [];
        foreach ($importedRawData as $row) {
            $this->trimRow($row);
            try {
                if (!in_array($row[0], $userIds)) {
                    $invalid[] = $this->formatInvalidData($row, __('admin_messages.user_not_found'));
                } elseif (!in_array($row[1], $validTypes)) {
                    $invalid[] = $this->formatInvalidData($row, __('admin_messages.rematch_type_invalid'));
                } elseif (Carbon::now()->format('Y-m-d') > Carbon::createFromFormat('Y-m-d', $row[2])) {
                    $invalid[] = $this->formatInvalidData($row, __('admin_messages.rematch_date_invalid'));
                } else {
                    $valid[] = $this->formatValidData($row);
                }
            } catch (\Exception $e) {
                $invalid[] = $this->formatInvalidData($row, __('admin_messages.date_format_invalid'));
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
     * Format valid data
     *
     * @param array $row
     * @return array
     */
    private function formatValidData($row)
    {
        return [
            'user_id' => $row[0],
            'status' => ParticipantsStatus::Awaiting,
            'dating_day_id' => $row[2]
        ];
    }

    /**
     * Format invalid data
     *
     * @param array $row
     * @param string $reason
     * @return array
     */
    private function formatInvalidData($row, $reason)
    {
        return [
            'user_id' => $row[0],
            'dating_day_id' => $row[2],
            'reason' => $reason,
        ];
    }

    /**
     * Remove accidental white-spaces
     *
     * @param $row
     */
    private function trimRow(&$row)
    {
        foreach ($row as $key => $item) {
            $row[$key] = trim($item);
        }
    }
}
