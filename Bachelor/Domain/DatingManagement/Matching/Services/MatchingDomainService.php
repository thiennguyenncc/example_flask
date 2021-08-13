<?php

namespace Bachelor\Domain\DatingManagement\Matching\Services;

use Bachelor\Domain\DatingManagement\Matching\Model\RematchingImporter;
use Maatwebsite\Excel\Excel;

/**
 * @TODO: refactor this feature after rematching done
 */
class MatchingDomainService
{
    private $participantRematchRepository;

    /**
     * MatchingRepository constructor.
     */
    public function __construct()
    {
        $this->participantRematchRepository = null;
    }

    /**
     * Import 12pm, 3pm rematching from csv to array
     *
     * @param string $filePath
     * @return array
     */
    public function importRematchingCsv($filePath): array
    {
        $importedData = (new RematchingImporter())->toArray($filePath, null, Excel::CSV);
        $importedData = reset($importedData);
        // remove header
        array_shift($importedData);

        return $importedData;
    }

    /**
     * Batch insert to rematching
     *
     * @param array $data format [ ['user_id' => int, 'status' => string, 'dating_day_id' => string] ]
     * @return array [ 'success' => [], 'failure' => [] ]
     */
    public function insertRematching($data): array
    {
        $result = ['success' => [], 'failure' => []];
        foreach ($data as $row) {
            try {
                $this->participantRematchRepository->insert($row);
                $result['success'][] = $row;
            } catch (\Exception $e) {
                $result['failure'][] = $row;
            }
        }
        return $result;
    }
}
