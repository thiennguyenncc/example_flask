<?php

namespace Bachelor\Domain\Base\TimeSetting\Model\Cycle;

use Carbon\Carbon;

abstract class Cycle
{
    /**
     * @return int
     */
    abstract protected function getBaseUnit();

    /**
     * Get cycle end time after n week(s) since start time
     *
     * @param string $start 'Y-m-d H:i:s'
     * @param int $numOfWeek
     * @return Carbon
     */
    public function getCycleEndAfterWeeks($start, $numOfWeek)
    {
        return Carbon::parse($start)->addSeconds($this->getBaseUnit() * $numOfWeek);
    }
}
