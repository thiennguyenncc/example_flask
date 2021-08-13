<?php

namespace Bachelor\Domain\Base\TimeSetting\Model\Cycle;

use Bachelor\Domain\Base\TimeSetting\Enums\Cycles;
use Bachelor\Domain\Base\TimeSetting\Model\CycleInterface;

class OneHour extends Cycle implements CycleInterface
{
    /**
     * @return string
     */
    public function getName()
    {
        return Cycles::OneHour;
    }

    /**
     * @return int
     */
    protected function getBaseUnit()
    {
        return 60 * 60;
    }
}
