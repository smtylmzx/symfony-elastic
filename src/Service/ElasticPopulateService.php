<?php


namespace App\Service;


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

            $this->createElasticClient();

            $this->createIndex();

            $this->addBulkDataInsert($personList);
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
     * @param array $personList
     */
    private function addBulkDataInsert(array $personList): void
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

        $this->bulkData($params);
    }
}
