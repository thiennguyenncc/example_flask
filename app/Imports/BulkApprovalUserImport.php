<?php


namespace App\Imports;

use Bachelor\Domain\PaymentManagement\UserPlan\Services\UserPlanService;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Enums\ImportApprovalStatus;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService;
use Bachelor\Port\Secondary\Database\UserManagement\User\Repository\UserRepository;
use Bachelor\Utility\Helpers\Log;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;



class BulkApprovalUserImport implements WithStartRow, OnEachRow, WithValidation, SkipsOnFailure, WithHeadingRow
{
    private UserRepository $userRepository;
    private UserPlanService $userPlanService;
    private UserTrialService $userTrialService;
    private UserDomainService $userDomainService;
    private $failures = [];
    /**
     * BulkApprovalUserImport constructor.
     */
    public function __construct()
    {
        $this->userRepository = resolve(UserRepository::class);
        $this->userPlanService = resolve(UserPlanService::class);
        $this->userTrialService = resolve(UserTrialService::class);
        $this->userDomainService = resolve(UserDomainService::class);
    }
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param Row $row
     */
    public function onRow(Row $row)
    {
        try {
            $userId = $row['user_id'];
            $approval = $row['approval'];
            $teamMemberRate = $row['team_members_rate'];
            $user = $this->userRepository->getById($userId, ['userInfoUpdatedTime']);

            if ($user) {
                $user->setTeamMemberRate($teamMemberRate);
                if (
                    $user->getGender() === UserGender::Female
                    && $teamMemberRate >= config('constants.boundary_of_high_team_member_rate')
                ) $user->setBRate(config('constants.default_b_rate_for_high_rated_female'));
                $this->userRepository->save($user);

                if ($approval == ImportApprovalStatus::Approved && !$user->isApproved()) {
                    $this->userDomainService->validateUserBeforeApprove($user);
                    $user->approve();
                    if ($user->getGender() === UserGender::Male) {
                        $this->userPlanService->createFirstUserPlan($user);
                        $this->userTrialService->startTrialIfValid($user);
                    }

                    $this->userRepository->save($user);
                }
            }
        } catch (\Exception $e) {
            Log::error("Error from upload file BulkApprovalUserImport " . $e->getMessage(), $row->toArray());
            $newFailure = new Failure($row->getIndex(), 'user_id', [$e->getMessage()], $row->toArray());
            array_push($this->failures, $newFailure);
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                Rule::exists('users', 'id')
            ],
            'approval' => ['required', 'in:' . implode(',', [ImportApprovalStatus::Approved, ImportApprovalStatus::UnApproved])],
            'team_members_rate' => ['required', 'gte:1', 'lte:10']
        ];
    }

    /**
     * @param Failure ...$failures
     */
    public function onFailure(Failure ...$failures)
    {
        Log::error("Error from upload file BulkApprovalUserImport", $failures);
        array_push($this->failures, $failures);
    }

    /**
     * @return array
     */
    public function getFailures(): array
    {
        return $this->failures;
    }
}
