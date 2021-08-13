<?php
namespace Bachelor\Domain\Base\TimeSetting\Traits;

use Carbon\Carbon;

trait SettingCronTimeFormatter
{

    /**
     * System date formatter
     *
     * @param int $timeSettingId
     * @param string $cronKey
     * @param string $cronValue
     * @param string $cronPattern
     * @return array
     */
    public function settingCronTimeFormatterFormatter(
        int $timeSettingId,
        string $cronKey,
        string $cronValue,
        string $cronPattern
    ): array
    {
        $now = Carbon::now()->toDateTimeString();

        $data = [];
        $data['time_setting_id'] = $timeSettingId;
        $data['key'] = $cronKey;
        $data['command'] = $cronValue;
        $data['pattern'] = $cronPattern;
        $data['created_at'] = $now;
        $data['updated_at'] = $now;

        return $data;
    }

    /**
     * @param $dateTime
     * @return string
     */
    public function cronPatternFormat($dateTime): string
    {
        $paresDayMonth = '*';
        $paresMonth = '*';

        $paresHour = Carbon::parse($dateTime)->format('H');
        $paresMinutes = Carbon::parse($dateTime)->format('i');
        $parseDay = strtoupper(Carbon::parse($dateTime)->format('D'));
        return $cronPattern = $paresMinutes . ' ' . $paresHour . ' ' . $paresDayMonth . ' ' . $paresMonth . ' ' . $parseDay;
    }
}
