<?php


namespace App\Tests;


use App\Entity\Person;
use App\Repository\PersonRepository;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

/**
 * Class PersonRepoTest
 * @package App\Tests
 */
class PersonRepoTest extends TestCase
{
    private const EXPECTED_PERSON_COUNT = 1;

    /**
     * @test
     */
    public function personRepoTest(): void
    {
        $faker = Factory::create('tr_TR');

        $person = (new Person())
            ->setId($faker->numberBetween(1,1))
            ->setFirstName($faker->firstName)
            ->setLastName($faker->lastName)
            ->setPhoneNumber($faker->phoneNumber)
            ->setAddress($faker->address);

        $personRepository = $this
            ->createMock(PersonRepository::class);

        $personRepository
            ->method('getAllData')
            ->willReturn([$person]);

        self::assertCount(
            self::EXPECTED_PERSON_COUNT,
            $personRepository->getAllData()
        );
    }
}
