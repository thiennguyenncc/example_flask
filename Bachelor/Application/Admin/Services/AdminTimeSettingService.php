<?php
namespace Bachelor\Application\Admin\Services;

use Bachelor\Application\Admin\Services\Interfaces\AdminTimeSettingServiceInterface;
use Bachelor\Domain\Base\TimeSetting\Services\TimeSettingService;
use Illuminate\Http\Response;

class AdminTimeSettingService implements AdminTimeSettingServiceInterface
{

    /**
     *
     * @var int
     */
    protected $status;

    /**
     *
     * @var string
     */
    protected $message;

    /**
     *
     * @var array
     */
    protected $data = [];

    /**
     *
     * @var TimeSettingService
     */
    private $timeSetting;

    /**
     * Time Setting Admin Service Constructor
     *
     * @param TimeSettingService $timeSetting
     */
    public function __construct(TimeSettingService $timeSetting)
    {
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');

        $this->timeSetting = $timeSetting;
    }

    /**
     * Create new cycle
     *
     * @param array $params
     * @return AdminTimeSettingServiceInterface
     */
    public function createNewCycle(array $params): AdminTimeSettingServiceInterface
    {
        $this->data = $this->timeSetting->createNewCycle($params['starts_at'], $params['cycle']);

        return $this;
    }

    /**
     * Renew existing cycle to next week
     *
     * @return AdminTimeSettingServiceInterface
     */
    public function renewTimecycle(): AdminTimeSettingServiceInterface
    {
        $this->data = $this->timeSetting->renewTimecycle();

        return $this;
    }

    /**
     * Gets time settings for admin
     *
     * @return AdminTimeSettingServiceInterface
     */
    public function getTimeSettings(): AdminTimeSettingServiceInterface
    {
        $this->data['cycle'] = $this->timeSetting->getCurrentCycle();
        $this->data['timings'] = $this->timeSetting->getSystemDates();

        return $this;
    }

    /**
     * Updates time settings for admin
     *
     * @param array $params
     * @return AdminTimeSettingServiceInterface
     */
    public function updateTimeSettings(array $params): AdminTimeSettingServiceInterface
    {
        $this->data = $this->timeSetting->updateTimeSetting($params['week_start'], $params['cycle']);

        return $this;
    }

    /**
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
