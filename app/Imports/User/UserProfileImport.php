<?php

namespace App\Imports\User;

use Bachelor\Domain\MasterDataManagement\School\Interfaces\SchoolRepositoryInterface;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserProfileImport implements ToModel, WithStartRow, WithHeadingRow, WithBatchInserts
{
    private SchoolRepositoryInterface $schoolRepository;

    public function __construct()
    {
        $this->schoolRepository = app()->make(SchoolRepositoryInterface::class);
    }

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
            $school = $this->schoolRepository->getSchoolBySchoolName($row['school_name']);
            DB::table('user_profile')->insert([
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'birthday' => $row['birthday'],
                'height' => $row['height'],
                'body_type' => $row['body_shape'],
                'marriage_intention' => $row['marraige_intention'],
                'character' => $row['character'],
                'smoking' => $row['smoking'],
                'drinking' => $row['drinking'],
                'divorce' => $row['divorce'],
                'annual_income' => $row['annual_income'],
                'appearance_strength' => $row['appearance_strength'],
                'appearance_features' => $row['appearance_features'],
                'education' => $row['education'],
                'school_id' => $school ? $school->getId() : null,
                'company_name' => $row['company_name'],
                'job' => $row['job'],
                'hobby' => $row['hobby'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Migrate user profile data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
