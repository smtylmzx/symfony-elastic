<?php


namespace App\Service;


use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * Class AbstractIndexer
 * @package App\Service
 */
abstract class AbstractIndexer implements ElasticInterface, ConfigurationInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $elasticHost = '127.0.0.1';

    /**
     * @var string
     */
    private $elasticPort = '32769';

    public function createElasticClient(): void
    {
        $this->client = ClientBuilder::create()
            ->setHosts([
                sprintf('%s:%s',
                    $this->elasticHost,
                    $this->elasticPort
                )
            ])
            ->build();
    }

    /**
     * @return bool
     */
    public function createIndex(): bool
    {
        $params = [
            'index' => $this->getIndexName()
        ];

        if (false === $this->client->indices()->exists($params)) {
            $this->client->indices()->create(
                $this->getIndexConfiguration()
            );
        }

        return true;
    }

    /**
     * @param array $params
     */
    public function addData(array $params): void
    {
        $this->client->index($params);
    }

    /**
     * @param array $params
     */
    public function bulkData(array $params): void
    {
        $this->client->bulk($params);
    }

    /**
     * @return bool
     */
    public function deleteIndex(): bool
    {
        $params = [
            'index' => $this->getIndexName()
        ];

        if (true === $this->client->indices()->exists($params)) {
            $this->client->indices()->delete(
                $this->getIndexName()
            );
        }

        return true;
    }

    /**
     * @param array $params
     * @return bool
     */
    public function find(array $params): bool
    {
        return true;
    }

    /**
     * @param string $searchTerm
     * @return array
     */
    public function search(string $searchTerm): array
    {
        $this->createElasticClient();

        $params = [
            'index' => $this->getIndexName(),
            'type' => $this->getDocumentType(),
            'body' => [
                'query' => [
                    'match' => [
                        'firstName' => $searchTerm
                    ]
                ]
            ]
        ];

        return $this->client->search($params);
    }
}
