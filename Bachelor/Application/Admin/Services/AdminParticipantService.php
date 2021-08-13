<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Application\Admin\Traits\ParticipantImportFormatter;
use Bachelor\Application\Admin\Traits\ParticipantListFormatter;
use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Services\ParticipantForRematchDomainService;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AdminParticipantService
{
    use ParticipantImportFormatter, ParticipantListFormatter;

    private ParticipantMainMatchService $participantMainMatchService;

    private ParticipantForRematchDomainService $participantForRematchDomainService;

    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    private DatingDomainService $datingDomainService;

    private int $status;

    private string $message;

    private array $data = [];

    public function __construct(
        ParticipantMainMatchService $participantMainMatchService,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        DatingDomainService $datingDomainService,
        ParticipantForRematchDomainService $participantForRematchDomainService
    )
    {
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');

        $this->participantMainMatchService = $participantMainMatchService;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->datingDomainService = $datingDomainService;
        $this->participantForRematchDomainService = $participantForRematchDomainService;
    }

    /**
     * @return $this
     */
    public function listAwaitingParticipants(): AdminParticipantService
    {
        $this->data = $this->participantMainMatchRepository->listAwaitingParticipantsWithPaginator()->toArray();

        return $this;
    }

    /**
     * @deprecated
     * Migrate participants from Excel, CSV file
     *
     * @param string $filePath
     * @return AdminParticipantService
     */
    public function migrateMainMatchingParticipants(string $filePath): AdminParticipantService
    {
        $importData = $this->participantMainMatchService->importCsv($filePath);

        $importData = $this->validateAndFormatImportData($importData);

        $this->data['aborted'] = $importData['invalid'];
        // only process valid data
        $importedData = $this->participantMainMatchService->migrateParticipants($importData['valid']);

        $this->updateUsersStatusAfterMigration(array_map(function ($row) {
            return $row['user_id'];
        }, $importedData['success']));

        $this->data['imported'] = count($importedData['success']);
        $this->data['failed_import'] = count($importedData['failure']);

        return $this;
    }

    /**
     * Reset all dates & participants
     *
     * @return AdminParticipantService
     */
    public function resetDatingAndParticipant(): AdminParticipantService
    {
        if(env('APP_ENV') == 'production') {
            throw new \Exception('This action is not allowed on production environment');
        }

        DB::beginTransaction();
        $this->datingDomainService->resetLastWeek();
        $this->participantMainMatchService->resetLastWeek();
        $this->participantForRematchDomainService->resetLastWeek();
        DB::commit();

        return $this;
    }

    /**
     * Handle Api response
     *
     * @return array
     */
    public function handleApiResponse(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }

}
