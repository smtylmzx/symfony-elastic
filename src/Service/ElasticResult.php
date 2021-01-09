<?php


namespace App\Service;


use App\Schema\ElasticResultSchema;

/**
 * Class ElasticResult
 * @package App\Service
 */
class ElasticResult
{
    /**
     * @param array $result
     * @return array
     */
    public static function buildResults(array $result): array
    {
        if (false === isset($result['hits']['hits'])) {
            return [];
        }

        foreach ($result['hits']['hits'] as $hit) {
            $results[] = (new ElasticResultSchema($hit['_source']))->toArray();
        }

        return $results;
    }
}
