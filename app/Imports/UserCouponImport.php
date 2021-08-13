<?php

namespace App\Imports;

use Bachelor\Domain\UserManagement\UserCoupon\Enum\UserCouponStatus;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao\UserCoupon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserCouponImport implements ToModel, WithStartRow, WithProgressBar
{
    use Importable;

    private $statusMapping = [
        'used' => UserCouponStatus::Used,
        'unused' => UserCouponStatus::Unused,
        'exchanged' => UserCouponStatus::Exchanged,
        'expired' => UserCouponStatus::Expired
    ];

    private $couponIdMapping = [
        '1' => '1',
        '2' => '1',
        '3' => '2'
    ];

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
            if (isset($row[1]) && isset($row[2])) {
                return new UserCoupon([
                    'user_id' => $row[1],
                    'coupon_id' => $this->couponIdMapping[$row[2]],
                    'status' => $this->statusMapping[$row[3]],
                    'expiry_at' => $row[4],
                    'created_at ' => $row[7],
                    'updated_at' => $row[8]
                ]);
            }
        } catch (\Exception $e) {
            Log::info('import user coupon error: ' . $e);
        }
    }
}
