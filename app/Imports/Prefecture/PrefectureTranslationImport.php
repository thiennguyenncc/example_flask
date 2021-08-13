<?php

namespace App\Imports\Prefecture;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\PrefectureTranslation;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PrefectureTranslationImport implements ToModel, WithStartRow, WithHeadingRow
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
            return new PrefectureTranslation([
                'id' => $row['id'],
                'prefecture_id' => $row['prefecture_id'],
                'language_id' => $row['lang_id'],
                'name' => $row['prefecture_name'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate prefecture translation fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
