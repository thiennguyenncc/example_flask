<?php

namespace App\Imports\Prefecture;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao\Area;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AreaImport implements ToModel, WithStartRow, WithHeadingRow
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
            return new Area([
                'id' => $row['id'],
                'prefecture_id' => $row['prefecture_id'],
                'name' => $row['name'],
                'status' => $row['status'],
                'admin_id' => $row['admin_id'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate area data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
