<?php

namespace App\Imports\Authentication;

use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserImport implements ToModel, WithStartRow, WithHeadingRow, WithBatchInserts
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
        try {
            $results = $this->mappingRegistrationStep($row);
            \DB::table('users')->insert([
                'id' => $row['id'],
                'name' => $row['name'],
                'gender' => $row['gender'],
                'email' => $row['email'],
                'mobile_number' => $row['mobile_number'],
                'status' => $results['status'] ?? $row['status'],
                'b_rate' => $row['user_rating'],
                'registration_steps' => $results['registration_steps'] ?? 0,
                'prefecture_id' => $row['prefecture_id'] ?: null,
                'support_tracking_url' => $row['support_tracking_shorturl'],
                'team_member_rate' => $row['team_member_rate'],
                'flex_point' => $row['flex_point'],
                'is_fake' => $row['is_fake'] == 'yes' ? 1 : 0,
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
            \DB::table('user_auth')->insert([
                'user_id' => $row['id'],
                'auth_type' => $row['social_type'],
                'auth_id' => $row['social_id'],
                'access_token' => $row['social_login_access_token'],
                'remember_token' => $row['remember_token'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
            \DB::table('user_login')->insert([
                'user_id' => $row['id'],
                'ip_address' => $row['ip_address'],
                'login_at' => $row['last_login'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
            \DB::table('user_invitation')->insert([
                'user_id' => $row['id'],
                'invitation_code' => $row['invitation_code'],
                'invitation_link' => $row['invitation_url'],
                'promotion_code' => $row['coupon_code']
            ]);

        } catch (\Exception $e) {
            Log::error('Migrate user login and user auth data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }

    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @param $user
     * @return array
     */
    private function mappingRegistrationStep($user): array
    {
        $results = [
            'registration_steps' => null,
            'status' => null
        ];
        if ($user['status'] == 1) { // Incomplete
            if ($user['team_member_rate'] == 0) {
                $results['status'] = UserStatus::IncompleteUser;
            } elseif ($user['team_member_rate'] > 0) {
                $results['status'] = UserStatus::CancelledUser;
            }
        }

        if ($user['registration_step'] == 0) {
            if ($user['status'] == 1) {// Incomplete
                $results['registration_steps'] = RegistrationSteps::StepOne;
            } else {
                $results['registration_steps'] = RegistrationSteps::StepBefore1stParticipateMain;
            }
        } elseif ($user['registration_step'] == 1) {
            $results['registration_steps'] = RegistrationSteps::StepBefore1stParticipateMain;
        } elseif ($user['registration_step'] == 2) {
            $results['registration_steps'] = RegistrationSteps::StepFinal;
        }

        return $results;
    }
}
