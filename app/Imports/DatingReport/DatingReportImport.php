<?php

namespace App\Imports\DatingReport;

use Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\ModelDao\DatingReport;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatingReportImport
{
    protected $datingReports;

    public function __construct($datingReports)
    {
        $this->datingReports = $datingReports;
    }

    public function handle()
    {
        try {
            DB::beginTransaction();
            foreach ($this->datingReports as $datingReport) {
                $user = User::where('id', $datingReport['user_id'])->first();
                if ($user) {
                    DatingReport::create([
                        'id' => $datingReport['id'],
                        'user_id' => $datingReport['user_id'],
                        'dating_report' => $datingReport['dating_report'],
                        'read' => $datingReport['read'],
                        'display_date' => $datingReport['created_at'],
                        'created_at' => $datingReport['created_at'],
                        'updated_at' => $datingReport['updated_at']
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Migrate dating report data fail on id: ' . $datingReport['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
