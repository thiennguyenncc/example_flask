<?php

namespace Bachelor\Domain\Base\TimeSetting\Model\Cycle;

use Bachelor\Domain\Base\TimeSetting\Enums\Cycles;
use Bachelor\Domain\Base\TimeSetting\Model\CycleInterface;

class FifteenMinutes extends Cycle implements CycleInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return Cycles::FifteenMinutes;
    }

    /**
     * @return int
     */
    protected function getBaseUnit()
    {
        return 60 * 16;
    }
}
