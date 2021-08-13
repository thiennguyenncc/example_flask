<?php

namespace Bachelor\Domain\Base\TimeSetting\Model\Cycle;

use Bachelor\Domain\Base\TimeSetting\Enums\Cycles;
use Bachelor\Domain\Base\TimeSetting\Model\CycleInterface;

class TwelveHours extends Cycle implements CycleInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return Cycles::TwelveHours;
    }

    /**
     * @return int
     */
    protected function getBaseUnit()
    {
        return 60 * 60 * 12;
    }
}
