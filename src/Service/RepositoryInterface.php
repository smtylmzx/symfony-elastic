<?php


namespace App\Service;


use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

/**
 * Class RepositoryInterface
 * @package App\Service
 */
interface RepositoryInterface extends ServiceEntityRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllData(): array;
}
