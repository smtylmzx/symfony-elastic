<?php


namespace App\Service;


use Elasticsearch\Client;

/**
 * Interface ElasticIndexInterface
 * @package App\Service
 */
interface ElasticIndexInterface
{
    /**
     * @param Client $client
     * @return bool
     */
    public function createIndex(Client $client): bool;

    /**
     * @param Client $client
     * @param array $params
     */
    public function addData(Client $client, array $params): void;

    /**
     * @param Client $client
     * @param array $params
     */
    public function bulkData(Client $client, array $params): void;

    /**
     * @param Client $client
     * @return bool
     */
    public function deleteIndex(Client $client): bool;

    /**
     * @param Client $client
     * @param array $params
     * @return bool
     */
    public function find(Client $client, array $params): bool;
}
