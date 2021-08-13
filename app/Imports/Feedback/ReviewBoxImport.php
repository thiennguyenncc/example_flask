<?php

namespace App\Imports\Feedback;

use Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewBox\ModelDao\ReviewBox;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ReviewBoxImport implements ToModel, WithStartRow, WithHeadingRow
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
            return new ReviewBox([
                'id' => $row['id'],
                'good_bad_type' => $row['type'],
                'label' => $row['label'],
                'description' => $row['description'],
                'feedback_by_gender' => $row['active_with'],
                'visible' => $row['visible'],
                'order_in_feedback' => $row['order'],
                'review_point_id' => $row['review_point_id'],
                'star_category_id' => $row['star_category_id'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate review boxes data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
