<?php
namespace Bachelor\Domain\Base\TimeSetting\Services;

use Bachelor\Domain\Base\TimeSetting\Traits\SettingCronTimeFormatter;;

use Bachelor\Port\Secondary\Database\Base\SystemCronTime\Repository\EloquentSettingCronTimeRepository;
use Bachelor\Port\Secondary\Database\Base\SystemDate\Repository\EloquentSystemDateRepository;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Bachelor\Port\Secondary\Database\Base\TimeSetting\Interfaces\EloquentTimeSettingInterface;
use Bachelor\Port\Secondary\Database\Base\TimeSetting\ModelDao\TimeSetting;
use Bachelor\Port\Secondary\Database\Base\SystemDate\Interfaces\EloquentSystemDateInterface;
use Bachelor\Domain\Base\TimeSetting\Enums\Cycles;
use Bachelor\Domain\Base\TimeSetting\Traits\TimeSettingFormatter;
use Bachelor\Domain\Base\TimeSetting\Traits\SystemDateFormatter;
use phpDocumentor\Reflection\Types\Collection;

class TimeSettingService
{

    use TimeSettingFormatter, SystemDateFormatter, SettingCronTimeFormatter;

    /**
     *
     * @var EloquentTimeSettingInterface
     */
    protected $timeSettingRepository;

    /**
     *
     * @var EloquentSystemDateRepository
     */
    protected $systemDateRepository;

    /**
     *
     * @var EloquentSettingCronTimeRepository
     */
    protected $settingCronTimeRepository;

    /**
     * TimeSettingRepository constructor.
     *
     * @param EloquentTimeSettingInterface $timeSettingRepository
     * @param EloquentSystemDateInterface $systemDateRepository
     * @param EloquentSettingCronTimeRepository $settingCronTimeRepository
     */
    public function __construct(
        EloquentTimeSettingInterface $timeSettingRepository,
        EloquentSystemDateInterface $systemDateRepository,
        EloquentSettingCronTimeRepository $settingCronTimeRepository
    )
    {
        $this->timeSettingRepository = $timeSettingRepository;
        $this->systemDateRepository = $systemDateRepository;
        $this->settingCronTimeRepository = $settingCronTimeRepository;
    }

    /**
     * Get all system dates
     *
     * @return array
     */
    public function getSystemDates(): array
    {
        return $this->getCachedSystemDate();
    }

    /**
     * Get system date by key
     *
     * @param string $timeKey
     * @return Carbon | null
     */
    public function getSystemDate($timeKey)
    {
        $cachedSystemDates = $this->getCachedSystemDate();

        return isset($cachedSystemDates[$timeKey]) ? Carbon::createFromFormat('Y-m-d H:i:s', $cachedSystemDates[$timeKey]) : null;
    }

    /**
     * Get current cycle
     *
     * @return string
     */
    public function getCurrentCycle(): string
    {
        $timeSetting = $this->timeSettingRepository->buildIndexQuery([])->first();

        return $timeSetting ? $timeSetting->cycle : Cycles::OneWeek;
    }

    /**
     * Creates new cycle
     *
     * @param string $startDate
     * @param string $cycle
     * @return bool
     */
    public function createNewCycle(string $startDate, string $cycle): bool
    {
        // TODO test when creating admin api task
        $timings = self::storeNewCycle(Carbon::parse($startDate), $cycle);

        return self::renewSystemDates($timings);
    }

    /**
     * Update existing time settings from save
     *
     * @param string $startDate
     * @param string $newCycle
     * @return array
     */
    public function updateTimeSetting(string $startDate, string $newCycle): array
    {
        $newTimings = self::getTimings(Carbon::parse($startDate), $newCycle);
        // Get Previous date from database
        $timeSetting = $this->timeSettingRepository->getModel()->first();
        if (! empty($timeSetting)) {
            $timeSetting->cycle = $newCycle;
            $timeSetting->starts_at = $newTimings['week_start'];
            $timeSetting->ends_at = $newTimings['week_end'];
            $timeSetting->update();
            $this->resetCacheSystemDate();
        }
        self::renewSystemDates($newTimings);
        return ['timings' => $newTimings, 'cycle' => $newCycle];
    }

    protected function resetCacheSystemDate(){
        Cache::forget('system_date');
    }

    /**
     * Renew cycle for next week
     *
     * @return bool
     */
    public function renewTimeCycle(): bool
    {
        if ($timings = self::renewTimeSettings()) {

            return self::renewSystemDates($timings) && self::renewSettingCronTime($timings);
        }

        return false;
    }

    /**
     * Renew time settings
     *
     * @return array
     */
    protected function renewTimeSettings(): array
    {
        // Get Previous date from database
        $timeSetting = $this->timeSettingRepository->getModel()->first();

        if (! empty($timeSetting)) {
            return self::updateExistingCycle($timeSetting);
        }

        return self::storeNewCycle(Carbon::now()->endOfWeek()->addSecond(), config('timings.cycles.1_week'));
    }

    /**
     * Renew system dates
     *
     * @param array $timings
     * @return bool
     */
    protected function renewSystemDates(array $timings): bool
    {
        $this->systemDateRepository->getModel()->truncate();

        $timeSetting = $this->timeSettingRepository->getModel()->first();

        $final = [];
        foreach ($timings as $timingKey => $timingValue) {

            $final[] = self::systemDateFormatter($timeSetting->id, $timingKey, $timingValue);
        }

        return $this->systemDateRepository->insert($final);
    }

    /**
     * Renew setting cron time
     *
     * @param array $timings
     * @return bool
     */
    protected function renewSettingCronTime(array $timings): bool
    {
        $this->settingCronTimeRepository->getModel()->truncate();

        $timeSetting = $this->timeSettingRepository->getModel()->first();

        $final = [];

        $cronJobs = config('timings.cron_jobs');

        foreach ($cronJobs as $cronKey => $cronValue) {

            if(empty($cronValue)) continue;
            $dateTime = $timings[$cronKey];

            $cronPatternFormat = self::cronPatternFormat($dateTime);

            $final[] = self::settingCronTimeFormatterFormatter(
                $timeSetting->id,
                $cronKey,
                $cronValue,
                $cronPatternFormat,
            );
        }
        return $this->settingCronTimeRepository->insert($final);
    }

    /**
     * Store new cycle settings
     *
     * @param Carbon $startDate
     * @param string $cycle
     * @return array
     */
    protected function storeNewCycle(Carbon $startDate, string $cycle): array
    {
        $timings = self::getTimings($startDate, $cycle);

        $data = self::timeSettingFormatter($timings, $cycle);

        $this->timeSettingRepository->create($data);
        return $timings;
    }

    /**
     * Update existing cycle settings
     *
     * @param TimeSetting $timeSetting
     * @return array
     */
    protected function updateExistingCycle(TimeSetting $timeSetting): array
    {
        $timings = self::getTimings(Carbon::parse($timeSetting['ends_at'])->addSecond(), $timeSetting['cycle']);

        $data = self::timeSettingFormatter($timings, $timeSetting['cycle']);

        $timeSetting->update($data);

        return $timings;
    }

    /**
     * Get timings in key and value pair
     *
     * @param Carbon $startDate
     * @param string $cycle
     * @return array
     */
    protected function getTimings(Carbon $startDate, string $cycle): array
    {
        switch ($cycle) {
            case config('timings.cycles.1_hour'):
                return self::getTestTimings($startDate, config('timings.second_config.seconds_in_1_hour'));

            case config('timings.cycles.12_hour'):
                return self::getTestTimings($startDate, config('timings.second_config.seconds_in_12_hours'));

            case config('timings.cycles.15_minute'):
                return self::getTestTimings($startDate, config('timings.second_config.seconds_in_15_minute'));

            default :
                 return self::getProdTimings($startDate);
        }
    }

    /**
     * Get test environment timings for 15 minute, 1 hour, 12 hour
     *
     * @param Carbon $startDate
     * @param int $convertedSeconds
     * @return array
     */
    protected function getTestTimings(Carbon $startDate, int $convertedSeconds): array
    {
        $timings = self::getUpdatedTimings($convertedSeconds);

        return self::calculateTimings($startDate, $timings);
    }

    /**
     * Get production environment time settings for 1 week cycle
     *
     * @param Carbon $startDate
     * @return array
     */
    protected function getProdTimings(Carbon $startDate): array
    {
        $timings = config('timings.day_time');

        return self::calculateTimings($startDate, $timings);
    }

    /**
     * Calculate the timings for all cycles
     *
     * @param Carbon $startDate
     * @param array $timings
     * @return array
     */
    protected function calculateTimings(Carbon $startDate, array $timings): array
    {
        $finalTimings = [];

        foreach ($timings as $timingKey => $timingAddSeconds) {

            // Carbon add seconds overwrites original value, clone object to preserve old value
            $datetimeString = clone $startDate;

            $finalTimings[$timingKey] = $datetimeString->addSeconds($timingAddSeconds)->toDateTimeString();
        }

        return self::mapKeyValueTiming($finalTimings);
    }

    /**
     * Calculates timings for test environment 12 hour, 1 hour, 15 mins
     *
     * @param float $seconds
     * @return array
     */
    protected function getUpdatedTimings(float $seconds): array
    {
        $timings = config('timings.day_time');

        $secondsInOneWeek = config('timings.second_config.seconds_in_1_week');

        return array_map(function ($e) use ($seconds, $secondsInOneWeek) {
            return floor($e * $seconds / $secondsInOneWeek);
        }, $timings);
    }

    /**
     * Maps key and value timings, only specified ones will be saved to database
     *
     * @param array $timings
     * @return array
     */
    protected function mapKeyValueTiming(array $timings): array
    {
        $systemKeys = config('timings.keys');
        $final = [];
        foreach ($systemKeys as $keys => $value) {
            $final[$keys] = $timings[$value];
        }

        return $final;
    }

    /**
     *
     * @return array
     */
    protected function getCachedSystemDate(): array
    {
        return Cache::remember('system_date', 5 * 60, function () {
            $systemDateConfigs = $this->systemDateRepository->getAllModelDao();
            $data = [];
            foreach ($systemDateConfigs as $systemDateConfig) {
                $data[$systemDateConfig->time_key] = $systemDateConfig->time_value;
            }
            return $data;
        });
    }

}
