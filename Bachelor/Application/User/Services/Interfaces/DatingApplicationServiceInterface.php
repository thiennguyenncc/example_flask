<?php

namespace Bachelor\Application\User\Services\Interfaces;

interface DatingApplicationServiceInterface
{
    /**
     * Get match profile
     *
     * @return array
     */
    public function getMatchProfile (): array;

    /**
     * Get match profile Detail
     *
     * @return array
     */
    public function getMatchProfileDetail (int $datingId): array;

    /**
     * User request to cancel dating
     *
     * @param array $params
     * @return array
     */
    public function cancelDating(array $params): array;

    /**
     * User request that cancelled by partner
     *
     * @param array $params
     * @return array
     */
    public function cancelledByPartner(array $params): array;
}
