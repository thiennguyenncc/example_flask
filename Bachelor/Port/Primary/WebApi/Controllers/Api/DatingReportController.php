<?php


namespace Bachelor\Port\Primary\WebApi\Controllers\Api;


use Bachelor\Application\User\Services\DatingReportService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatingReportController extends BaseController
{
    /**
     * @param Request $request
     * @param DatingReportService $datingReportService
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": array
     * }
     *
     */
    public function getDatingReportInfo(Request $request, DatingReportService $datingReportService): JsonResponse
    {
        $user = Auth::user()->getDomainEntity();
        $datingReportId = $request->get('dating_report_id');
        $datingReportData = $datingReportService->getDatingReportInfo($user, $datingReportId);
        $showPopup = $datingReportService->checkShowPopup($user);

        return ApiResponseHandler::jsonResponse(200, __('api_messages.successful'), [
            'dating_report' => $datingReportData,
            'show_popup' => $showPopup
        ]);

    }
}
