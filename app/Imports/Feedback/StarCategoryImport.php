<?php

namespace App\Imports\Feedback;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Category\ModelDao\StarCategory;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StarCategoryImport implements ToModel, WithStartRow, WithHeadingRow
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
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            return new StarCategory([
                'id' => $row['id'],
                'label' => $row['label'],
                'status' => $row['status'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate star category data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
