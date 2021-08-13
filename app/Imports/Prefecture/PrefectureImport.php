<?php

namespace App\Imports\Prefecture;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PrefectureImport implements ToModel, WithStartRow, WithHeadingRow
{
    const JAPAN = 1;
    const VIET_NAM = 2;
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
            return new Prefecture([
                'id' => $row['id'],
                'country_id' => self::JAPAN, // Default country id
                'admin_id' => $row['admin_id'],
                'name' => $row['name'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate prefecture fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
