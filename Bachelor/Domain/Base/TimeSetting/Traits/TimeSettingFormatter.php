<?php
namespace Bachelor\Domain\Base\TimeSetting\Traits;

trait TimeSettingFormatter
{

    /**
     * Time setting formatter
     *
     * @param array $timings
     * @param string $cycle
     * @return array
     */
    public function timeSettingFormatter(array $timings, string $cycle): array
    {
        $data = [];
        $data['cycle'] = $cycle;
        $data['starts_at'] = $timings['week_start'];
        $data['ends_at'] = $timings['week_end'];

        return $data;
    }
}
