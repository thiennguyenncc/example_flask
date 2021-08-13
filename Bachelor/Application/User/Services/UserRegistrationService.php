<?php

namespace Bachelor\Application\User\Services;

use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\RegistrationFormRequest;
use Bachelor\Domain\MasterDataManagement\School\Interfaces\SchoolRepositoryInterface;
use Bachelor\Domain\UserManagement\Registration\Services\RegistrationService;
use Bachelor\Utility\Enums\Status;
use Bachelor\Utility\Helpers\Utility;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;

class UserRegistrationService
{
    private RegistrationService $registration;

    /**
     * @var SchoolRepositoryInterface
     */
    private $schoolService;

    private $status;

    /**
     * @var string
     */
    private $message;

    /*
     * @var array
     */
    private $data = [];

    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    private $participantMainMatchRepository;

    /**
     * UserRegistrationService constructor.
     * @param RegistrationService $registration
     * @param SchoolRepositoryInterface $schoolService
     * @param NotificationService $notificationService
     * @param ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
     */
    public function __construct(
        RegistrationService $registration,
        NotificationService $notificationService,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        SchoolRepositoryInterface $schoolService
    ) {
        $this->registration = $registration;
        $this->schoolService = $schoolService;
        $this->notificationService = $notificationService;
        $this->participantMainMatchRepository = $participantMainMatchRepository;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get registration data for authenticated user
     *
     * @return array
     */
    public function retrieveDataAuthorizedUserForRegistration(int $step): array
    {
        $this->data = $this->registration->getUserDataForRegistration(Auth::user()->getDomainEntity(), $step);
        return $this->handleApiResponse();
    }

    /**
     * Store registration form data for authorized user and get data to populate the first step of the registration form
     *
     * @param RegistrationFormRequest $request
     * @return array
     * @throws Exception
     */
    public function storeAndRetrieveDataForNextRegistrationStep(array $data, int $step): array
    {
        // Retrieve user auth dat
        $user = Auth::user()->getDomainEntity();

        // Store registration step data
        if ($this->registration->storeUserDataFromRegistrationForm($user, $step, $data)) {
            $this->data = $this->registration->getUserDataForRegistration($user, $step + 1);
            return $this->handleApiResponse();
        }

        throw new Exception(__('api_messages.error_while_storing_registration_data'), [
            'step' => $data['currentStep']
        ]);
    }

    /**
     * @param ImageUploadRequest $request
     * @return array
     */
    public function storeImage(ImageUploadRequest $request): array
    {
        // Retrieve user auth data
        $userAuth = Auth::user()->getDomainEntity();
        $files = $request->file('profileImages');
        $result = [];
        foreach ($files as $file) {
            $imageName = $userAuth->getId() . '_' . Carbon::now()->timestamp . '_' . $file->getClientOriginalName();

            Utility::storeFile($file, config('constants.user_profile_storage_path'), $imageName);

            $result[] = [
                'url' => Utility::getFileLink($imageName, config('constants.user_profile_storage_path'))
            ];
        }

        return [
            'status' => Response::HTTP_OK,
            'message' => __('api_messages.successful'),
            'data' => $result
        ];
    }

    /**
     * Format Registration data
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
