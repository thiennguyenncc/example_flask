<?php

namespace App\Http\Traits\Validations;

use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Interfaces\SendableEmailRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Rules\SendableEmail;
use Illuminate\Support\Facades\Auth;

trait ValidationRules
{
    private SendableEmailRepositoryInterface $sendableEmailRepository;
    /**
     * Validation rules for step one
     *
     * @return array
     */
    public static function rulesStepZero() : array
    {
        return [
            'prefectureId' => 'required|integer',
            'gender' => 'required|integer',
            'year' => 'required|integer',
            'month' => 'required|integer',
            'date' => 'required|integer',
            'code' => 'required|string|nullable',
            'email' => ['required', new SendableEmail]
        ];
    }
    /**
     * Validation rules for step one
     *
     * @return array
     */
    public static function rulesStepOne() : array
    {
        return [
            'facePreferences' => 'required|string',
        ];
    }

    /**
     * Validation rules for step two
     *
     * @return array
     */
    protected static function rulesStepTwo() : array
    {
        return [
            'minAge' => 'required|int',
            'maxAge' => 'required|int',
            'minHeight' => 'required|int',
            'maxHeight' => 'required|int',
            'job' => 'nullable|string',
        ];
    }

    /**
     * Validation rules for step two
     *
     * @return array
     */
    protected static function rulesStepThree() : array
    {
        return [
            'bodyType1' => 'required|int',
            'bodyType2' => 'required|int',
            'education' => 'required|int',
        ];
    }

    /**
     * Validation rules for step three
     *
     * @return array
     */
    protected static function rulesStepFour() : array
    {
        return [
            'alcohol' => 'required|int',
            'divorce' => 'required|int',
        ];
    }

    /**
     * Validation rules for step four
     *
     * @return array
     */
    protected static function rulesStepFive() : array
    {
        return [
            'smoking' => 'required|string',
            'annualIncome' => 'required|int',
        ];
    }

    /**
     * Validation rules for step five
     *
     * @return array
     */
    protected static function rulesStepSix() : array
    {
        return [
            'userName' => 'required|string',
            'job' => 'required|int',
            'annualIncome' => 'nullable|int',
            'education' => 'nullable|int',
            'schoolId' => 'nullable|int',
        ];
    }

    /**
     * Validation rules for step six
     *
     * @return array
     */
    protected static function rulesStepSeven() : array
    {
        return [
            'images' => 'required|string'
        ];
    }

    /**
     * Step eight rules
     *
     * @return array
     */
    private static function rulesStepEight() : array
    {
        return [
            'height' => 'required|int',
            'bodyType' => 'required|int',
            'education' => 'required|int',
        ];
    }

    /**
     * Step Nine rules
     *
     * @return array
     */
    private static function rulesStepNine() : array
    {
        return [
            'appearanceStrength' => 'required|array'
        ];
    }

    /**
     * Step Ten rules
     *
     * @return array
     */
    private static function rulesStepTen() : array
    {
        return [
            'character' => 'required|string'
        ];
    }

    /**
     * Step Eleven rules
     *
     * @return array
     */
    private static function rulesStepEleven() : array
    {
        return [
            'hobby' => 'required|string'
        ];
    }

    /**
     * Step Twelve rules
     *
     * @return array
     */
    private static function rulesStepTwelve() : array
    {
        return [
            'alcohol' => 'required|string',
            'smoking' => 'nullable|string',
        ];
    }

    /**
     * Step Thirteenth rules
     *
     * @return array
     */
    private static function rulesStepThirteenth() : array
    {
        return [
            'divorce' => 'required|int',
            'willingnessForMarriage' => 'required|int',
        ];
    }

    /**
     * Step Fourteenth rules
     *
     * @return array
     */
    private static function rulesStepFourteenth() : array
    {
        return [
            'importantPreferences' => 'required|array',
            'importanceOfLookValue' => 'required|int',
        ];
    }

    /**
     * Step Fifteenth rules
     *
     * @return array
     */
    private static function rulesStepFifteenth() : array
    {
        return [
            'userPreferredAreas' => 'required|array'
        ];
    }
}
