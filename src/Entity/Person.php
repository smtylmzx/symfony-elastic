<?php


namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonRepository;

/**
 * Class Person
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string|null
     * @ORM\Column(
     *     name="first_name",
     *     type="string",
     *     length=100,
     *     nullable=true
     * )
     */
    private $firstName;

    /**
     * @var string|null
     * @ORM\Column(
     *     name="last_name",
     *     type="string",
     *     length=100,
     *     nullable=true
     * )
     */
    private $lastName;

    /**
     * @var string|null
     * @ORM\Column(
     *     name="phone_number",
     *     type="string",
     *     length=100,
     *     nullable=true
     * )
     */
    private $phoneNumber;

    /**
     * @var string|null
     * @ORM\Column(
     *     name="address",
     *     type="text",
     *     nullable=true
     * )
     */
    private $address;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     * @return self
     */
    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     * @return self
     */
    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string|null $phoneNumber
     * @return self
     */
    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     * @return self
     */
    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s %s',
            $this->getFirstName(),
            $this->getLastName()
        );
    }

    /**
     * @param $fieldName
     * @param $value
     */
    public function __set($fieldName, $value)
    {
        $this->{$fieldName} = $value;
    }

    /**
     * @param $fieldName
     * @return mixed
     */
    public function __get($fieldName)
    {
        return $this->{$fieldName};
    }

    /**
     * @param $name
     */
    public function __isset($name)
    {
        // TODO: Implement __isset() method.
    }
}
