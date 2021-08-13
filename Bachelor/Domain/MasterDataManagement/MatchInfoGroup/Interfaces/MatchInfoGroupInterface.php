<?php

namespace Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Interfaces;

use Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models\MatchInfoGroup;
use Illuminate\Support\Collection;

interface MatchInfoGroupInterface
{
    /**
     * Get all groups
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get by id
     *
     * @return MatchInfoGroup
     */
    public function getByInfoId(int $id): MatchInfoGroup;

    /**
     * @param MatchInfoGroup $dating
     * @return MatchInfoGroup
     */
    public function save(MatchInfoGroup $matchInfoGroup): MatchInfoGroup;

    /**
     * Delete exsting Group
     *
     * @return Bool
     */
    public function deleteGroup(int $id): bool;

    /**
     * Filter groups type
     *
     * @return Collection
     */
    public function filterGroupByAgeAndGender(int $age, int $gender): Collection;
}
