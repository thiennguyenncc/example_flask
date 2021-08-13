<?php

namespace App\Imports;

use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUserCancellForm;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DatingUserCancelFormImPort implements ToModel, WithStartRow
{
    private $isFirstTime;
    private $index;

    public function __construct($isFirstTime = false, int $index = 4)
    {
        $this->isFirstTime = $isFirstTime;
        $this->index = $index;
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
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            $datingUser = DatingUser::where('dating_id', $row[5])->where('user_id', $row[6])->first();
            if ($datingUser != null) {
                $datingUserExist = DatingUserCancellForm::find($row[0]);
                if (! $datingUserExist) {
                    return new DatingUserCancellForm([
                        'id' => $row[0],
                        'dating_user_id' => $datingUser->id,
                        'reason_for_cancellation' => $row[1],
                        'reason_for_cancellation_other_text' => $row[2],
                        'reason_for_cancellation_dissatisfaction_other_text' => $row[3],
                        'detailed_reason' => $row[4],
                        'created_at' => $row[8],
                        'updated_at' => $row[9],
                    ]);
                }
            } else {
                Log::info('dating user data not found with id: ' . $row[0]);
            }

        } catch (\Exception $e) {
            Log::info('import dating user cancelled form error: ' . $e);
        }
    }
}
