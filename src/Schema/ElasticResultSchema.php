<?php


namespace App\Schema;


/**
 * Class ElasticResultSchema
 * @package App\Schema
 */
class ElasticResultSchema
{
    /**
     * @var array
     */
    private $hit;

    /**
     * ElasticResultSchema constructor.
     * @param mixed $hit
     */
    public function __construct($hit)
    {
        $this->hit = $hit;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->hit['id'];
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->hit['firstName'];
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->hit['lastName'];
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->hit['address'];
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->hit['phoneNumber'];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'address' => $this->getAddress(),
            'phoneNumber' => $this->getPhoneNumber()
        ];
    }
}
