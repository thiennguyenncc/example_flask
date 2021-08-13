<?php

namespace App\Imports\Prefecture;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Area\ModelDao\AreaTranslation;
use Bachelor\Utility\Helpers\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AreaTranslationImport implements ToModel, WithStartRow, WithHeadingRow
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
            return new AreaTranslation([
                'id' => $row['id'],
                'area_id' => $row['area_id'],
                'language_id' => $row['lang_id'],
                'name' => $row['area_name'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate area translation data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
