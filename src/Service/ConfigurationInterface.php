<?php


namespace App\Service;


/**
 * Interface ConfigurationInterface
 * @package App\Service
 */
interface ConfigurationInterface
{
    /**
     * @return array
     */
    public function getIndexConfiguration(): array;

    /**
     * @return string
     */
    public function getIndexName(): string;

    /**
     * @return string
     */
    public function getDocumentType(): string;
}
