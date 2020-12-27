<?php


namespace App\Repository;


use App\Entity\Person;
use App\Service\RepositoryInterface;
use Faker\Factory;

/**
 * Class PersonRepository
 * @package App\Repository
 */
class PersonRepository implements RepositoryInterface
{
    private const COUNT = 1000;

    /**
     * @return array
     */
    public function getAllData(): array
    {
        $faker = Factory::create('tr_TR');

        $responseData = [];

        for ($i = 0; $i < self::COUNT; $i++) {
            $person = (new Person())
                ->setId($i + 1)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPhoneNumber($faker->phoneNumber)
                ->setAddress(
                    sprintf('%s %s',
                        $faker->streetAddress,
                        $faker->city
                    )
                );

            $responseData[] = $person->toArray();
        }

        return $responseData;
    }
}
