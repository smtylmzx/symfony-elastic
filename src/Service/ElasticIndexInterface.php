<?php


namespace App\Service;


/**
 * Interface ElasticIndexInterface
 * @package App\Service
 */
interface ElasticIndexInterface
{
    /**
     * @return bool
     */
    public function createIndex(): bool;

    /**
     * @param array $params
     */
    public function addData(array $params): void;

    /**
     * @param array $params
     */
    public function bulkData(array $params): void;

    /**
     * @return bool
     */
    public function deleteIndex(): bool;

    /**
     * @param array $params
     * @return bool
     */
    public function find(array $params): bool;
}
