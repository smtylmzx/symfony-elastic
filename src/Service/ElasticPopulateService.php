<?php


namespace App\Service;


use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * Class ElasticPopulateService
 * @package App\Service
 */
class ElasticPopulateService extends AbstractIndexer
{
    private const INDEX_NAME = 'person';

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var string
     */
    private $elasticHost = '127.0.0.1';

    /**
     * @var string
     */
    private $elasticPort = '32769';

    /**
     * ElasticPopulateService constructor.
     * @param RepositoryInterface $repository
     */
    public function __construct(
        RepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    /**
     * @return bool
     */
    public function populate(): bool
    {
        try {
            $personList = $this->getPersonList();

            $client = $this->createElasticClient();

            $this->createIndex($client);

            $this->addBulkDataInsert($client, $personList);
        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        return true;
    }

    /**
     * @return array
     */
    private function getPersonList(): array
    {
        return $this->repository->getAllData();
    }

    /**
     * @return Client
     */
    private function createElasticClient(): Client
    {
        return ClientBuilder::create()
            ->setHosts([
                sprintf('%s:%s',
                    $this->elasticHost,
                    $this->elasticPort
                )
            ])
            ->build();
    }

    /**
     * @return array
     */
    public function getIndexConfiguration(): array
    {
        return [
            'index' => self::INDEX_NAME,
            'body' => [
                'settings' => [
                    'number_of_shards' => 2,
                    'number_of_replicas' => 0
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getIndexName(): string
    {
        return self::INDEX_NAME;
    }

    /**
     * @return string
     */
    public function getDocumentType(): string
    {
        return $this->getIndexName();
    }

    /**
     * @param Client $client
     * @param array $personList
     */
    private function addBulkDataInsert(Client $client, array $personList): void
    {
        $params = [];

        foreach ($personList as $person) {
            $params['body'][] = [
                'index' => [
                    '_index' => $this->getIndexName(),
                    '_type' => $this->getDocumentType(),
                ]
            ];

            $params['body'][] = $person;
        }

        $this->bulkData($client, $params);
    }
}
