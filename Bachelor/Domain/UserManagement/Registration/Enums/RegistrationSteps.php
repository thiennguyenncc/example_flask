<?php

namespace Bachelor\Domain\UserManagement\Registration\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static static StepOne()
 * @method static static StepTwo()
 * @method static static StepThree()
 * @method static static StepFour()
 * @method static static StepFive()
 * @method static static StepSix()
 * @method static static StepSeven()
 * @method static static StepEight()
 * @method static static StepNine()
 * @method static static StepTen()
 * @method static static StepEleven()
 * @method static static StepTwelve()
 * @method static static StepThirteenth()
 * @method static static StepFourteenth()
 * @method static static StepFifteenth()
 * @method static static StepSixteenth()
 */
final class RegistrationSteps extends IntEnum
{
    const StepZero = 0;
    const StepOne = 1;
    const StepTwo = 2;
    const StepThree = 3;
    const StepFour = 4;
    const StepFive = 5;
    const StepSix = 6;
    const StepSeven = 7;
    const StepEight = 8;
    const StepNine = 9;
    const StepTen = 10;
    const StepEleven = 11;
    const StepTwelve = 12;
    const StepThirteenth = 13;
    const StepFourteenth = 14;
    const StepFifteenth = 15;
    const StepSixteenth = 16;

    const StepBefore1stParticipateMain = 7;
    const StepBeforeFinal = 15;
    const StepFinal = 16;
}
