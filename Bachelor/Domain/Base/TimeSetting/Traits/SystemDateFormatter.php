<?php
namespace Bachelor\Domain\Base\TimeSetting\Traits;

use Carbon\Carbon;

trait SystemDateFormatter
{

    /**
     * System date formatter
     *
     * @param int $timeSettingId
     * @param string $timingKey
     * @param string $timingValue
     * @return array
     */
    public function systemDateFormatter(int $timeSettingId, string $timingKey, string $timingValue): array
    {
        $now = Carbon::now()->toDateTimeString();

        $data = [];
        $data['time_setting_id'] = $timeSettingId;
        $data['time_key'] = $timingKey;
        $data['time_value'] = $timingValue;
        $data['created_at'] = $now;
        $data['updated_at'] = $now;

        return $data;
    }
}
