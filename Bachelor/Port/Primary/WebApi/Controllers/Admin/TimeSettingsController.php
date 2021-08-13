<?php
namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Bachelor\Application\Admin\Services\Interfaces\AdminTimeSettingServiceInterface;
use Illuminate\Http\JsonResponse;
use Exception;
use App\Http\Requests\Admin\TimeSettingsRequest;

/**
 * Class SettingsController
 *
 * @package Bachelor\Port\Primary\WebApi\Controllers\Admin
 *
 * @group Admin Settings
 */
class TimeSettingsController extends BaseController
{

    private $timeSettingService;

    public function __construct(AdminTimeSettingServiceInterface $timeSettingService)
    {
        $this->timeSettingService = $timeSettingService;
    }

    /**
     * List all system timings
     *
     * @return JsonResponse
     *
     * @group Time Settings
     * @url admin/time-settings
     *
     * @response 200 {
     *      "message":"Successful",
     *      "data":{
     *         "cycle": "1_week",
     *         "timings": {
     *            "week_start": "2021-02-22 00:00:00",
     *            "week_end": "2021-02-28 23:59:59",
     *            "renew_cycle": "2021-02-28 23:59:59"
     *        }
     *     }
     *  }
     * @response 512 {
     *      "message":"Error encountered while retrieving timings in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Admin\/TimeSettingsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function getTimings(): JsonResponse
    {
        // Retrieve all timings
        $response = $this->timeSettingService->getTimeSettings()->handleApiResponse();

        // Set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Update system timings
     *
     * @return JsonResponse
     *
     * @group Time Settings
     * @url admin/time-settings
     *
     * @response 200 {
     *      "message":"Successful",
     *         "data": {
     *                "timings": {
     *                    "week_start": "2021-03-12 00:00:00",
     *                    "week_end": "2021-03-12 00:59:59",
     *                    "renew_cycle": "2021-03-12 00:59:59"
     *                },
     *                "cycle": "1_hour"
     *            }
     *  }
     * @response 512 {
     *      "message":"Error encountered while update timings in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Admin\/TimeSettingsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function updateTimings(TimeSettingsRequest $request): JsonResponse
    {
        // Retrieve all timings
        $response = $this->timeSettingService->updateTimeSettings($request->all())
            ->handleApiResponse();

        // Set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
