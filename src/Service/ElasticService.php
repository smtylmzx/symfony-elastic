<?php


namespace App\Service;


/**
 * Class ElasticService
 * @package App\Service
 */
class ElasticService extends AbstractIndexer
{
    private const INDEX_NAME = 'person';

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * ElasticService constructor.
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
                'settings' => $this->getSettings(),
                'mappings' => [
                    $this->getDocumentType() => [
                        'properties' => $this->getMappingProperties()
                    ]
                ]
            ],
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

    /**
     * @return array
     */
    private function getSettings(): array
    {
        return [
            'number_of_shards' => 2,
            'number_of_replicas' => 0,
            'analysis' => [
                'filter' => [
                    'autocomplete_filter' => [
                        'type' => 'edge_ngram',
                        'min_gram' => 1,
                        'max_gram' => 20
                    ]
                ],
                'analyzer' => [
                    'autocomplete' => [
                        'type' => 'custom',
                        'tokenizer' => 'standard',
                        'filter' => [
                            'lowercase',
                            'autocomplete_filter'
                        ]
                    ]
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    private function getMappingProperties(): array
    {
        return [
            'id' => [
                'type' => 'long'
            ],
            'firstName' => [
                'type' => 'string',
                'analyzer' => 'autocomplete',
                'search_analyzer' => 'standard',
                'preserve_separators' => false
            ],
            'lastName' => [
                'type' => 'string'
            ],
            'address' => [
                'type' => 'string',
                'index' => 'not_analyzed'
            ],
            'phoneNumber' => [
                'type' => 'string',
                'index' => 'not_analyzed'
            ]
        ];
    }
}
