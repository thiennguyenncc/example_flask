<?php

namespace Bachelor\Domain\Base\TimeSetting\Factories;

use Bachelor\Domain\Base\TimeSetting\Enums\Cycles;
use Bachelor\Domain\Base\TimeSetting\Model\CycleInterface;

class CycleFactory
{
    /**
     * Create a cycle based on input string
     *
     * @see \Bachelor\Domain\Base\TimeSetting\Enums\Cycles
     * @param string $cycle
     * @return CycleInterface | null
     */
    public static function create($cycle)
    {
        $class = 'Bachelor\\Domain\\Base\\TimeSetting\\Model\\Cycle\\' . Cycles::getKey($cycle);
        if (class_exists($class)) {
            return new $class();
        }
        return null;
    }
}
