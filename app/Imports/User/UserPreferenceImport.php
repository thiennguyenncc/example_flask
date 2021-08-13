<?php

namespace App\Imports\User;

use Bachelor\Utility\Helpers\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserPreferenceImport implements ToModel, WithStartRow, WithHeadingRow, WithBatchInserts
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
     * @return Model|Model[]|void|null
     */
    public function model(array $row)
    {
        DB::beginTransaction();
        try {
            DB::table('user_preference')->insert([
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'age_from' => $row['age_from'],
                'age_to' => $row['age_to'],
                'height_to' => $row['height_to'],
                'height_from' => $row['height_from'],
                'partner_body_min' => $row['partner_body_min'],
                'partner_body_max' => $row['partner_body_max'],
                'smoking' => $row['smoking'],
                'drinking' => $row['drinking'],
                'divorce' => $row['divorce'],
                'annual_income' => $row['annual_income'],
                'education' => $row['education'],
                'job' => $row['job'],
                'face_preferences' => $row['face_preferences'],
                'appearance_priority' => $row['appearance_priority'],
                'first_priority' => $row['first_priority'],
                'second_priority' => $row['second_priority'],
                'third_priority' => $row['third_priority'],
                'hobby' => $row['hobby'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Migrate user preference data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
