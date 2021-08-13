<?php

namespace App\Imports\Prefecture;

use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DatingPlaceImport implements ToModel, WithStartRow, WithHeadingRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        try {
            if ($row['phone']) {
                return new DatingPlace([
                    'id' => $row['id'],
                    'area_id' => $row['area_id'],
                    'train_station_id' => $row['train_station_id'] ?? 1,
                    'category' => $row['category'],
                    'latitude' => $row['latitude'],
                    'longitude' => $row['longitude'],
                    'rating' => $row['rating'],
                    'display_phone' => $row['display_phone'],
                    'phone' => $row['phone'],
                    'reference_page_link' => "a",
                    'status' => $row['status'],
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at']
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Migrate dating place data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
