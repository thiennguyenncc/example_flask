<?php

namespace Bachelor\Domain\Base\TimeSetting\Model;

use Carbon\Carbon;

interface CycleInterface
{
    /**
     * Get cycle name
     *
     * @return string
     */
    public function getName();

    /**
     * Get cycle end time after n week(s) since start time
     *
     * @param string $start 'Y-m-d H:i:s'
     * @param int $numOfWeek
     * @return Carbon
     */
    public function getCycleEndAfterWeeks($start, $numOfWeek);
}
