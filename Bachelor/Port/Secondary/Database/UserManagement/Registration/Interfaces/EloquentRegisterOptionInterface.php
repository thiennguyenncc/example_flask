<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\Registration\Interfaces;

use Bachelor\Port\Secondary\Database\UserManagement\Registration\ModelDao\RegisterOption;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\ModelDao\RegisterOptionTranslation;
use Illuminate\Support\Collection;

interface EloquentRegisterOptionInterface
{
    /**
     * get register option display name
     *
     * @param mixed $optionValue
     * @param string $type
     * @param integer|null $gender
     * @return string
     */
    public function getRegisterOptionDisplayName(mixed $optionValue, string $type, ?int $gender = null) :string;

    /**
     * get register option display name by array
     *
     * @param array $optionValues
     * @param string $type
     * @param integer|null $gender
     * @return array
     */
    public function getRegisterOptionDisplayNames(array $optionValues, string $type, ?int $gender = null) :array;

    /**
     * Create new register option translation
     *
     * @param RegisterOption $model
     * @param array $data
     */
    public function createRegisterOptionTranslation(RegisterOption $model, array $data);

    /**
     * Create new register option translation
     *
     * @param RegisterOption $model
     * @param array $data
     * @return
     */
    public function firstOrCreateRegisterOptionTranslation(RegisterOption $model, array $data);

    /**
     * Create new register option translation
     *
     * @param RegisterOption $model
     * @param array $data
     * @return
     */
    public function firstOrNewRegisterOptionTranslation(RegisterOption $model, array $data);

    /**
     * Create new register option translation
     *
     * @param RegisterOption $model
     * @param array $data
     * @return
     */
    public function updateOrCreateRegisterOptionTranslation(RegisterOption $model, array $data);

    /**
     * Create new register option translation
     *
     * @param RegisterOptionTranslation $model
     * @param array $fill
     * @return
     */
    public function replicateRegisterOptionTranslation(RegisterOptionTranslation $model, array $fill);

    /**
     * @param string $type
     * @param int $gender
     * @return Collection
     */
    public function getRegistrationOptionByType($type, int $gender = 0): Collection;

    /**
     * @param array $types
     * @param int $gender
     * @return Collection
     */
    public function getRegistrationOptionByTypes($optionType, int $gender = 0): Collection;
}
