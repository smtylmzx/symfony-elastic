<?php


namespace App\Service;


use Elasticsearch\Client;

/**
 * Class AbstractIndexer
 * @package App\Service
 */
abstract class AbstractIndexer implements ElasticIndexInterface, ConfigurationInterface
{
    /**
     * @param Client $client
     * @return bool
     */
    public function createIndex(Client $client): bool
    {
        $params = [
            'index' => $this->getIndexName()
        ];

        if (false === $client->indices()->exists($params)) {
            $client->indices()->create(
                $this->getIndexConfiguration()
            );
        }

        return true;
    }

    /**
     * @param Client $client
     * @param array $params
     */
    public function addData(Client $client, array $params): void
    {
        $client->index($params);
    }

    /**
     * @param Client $client
     * @param array $params
     */
    public function bulkData(Client $client, array $params): void
    {
        $client->bulk($params);
    }

    /**
     * @param Client $client
     * @return bool
     */
    public function deleteIndex(Client $client): bool
    {
        $params = [
            'index' => $this->getIndexName()
        ];

        if (true === $client->indices()->exists($params)) {
            $client->indices()->delete(
                $this->getIndexName()
            );
        }

        return true;
    }

    /**
     * @param Client $client
     * @param array $params
     * @return bool
     */
    public function find(Client $client, array $params): bool
    {
        return true;
    }
}
