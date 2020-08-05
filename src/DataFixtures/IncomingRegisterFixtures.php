<?php

namespace Mateu\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\AnimalRegisters\Domain\Entity\AnimalRegisters;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;

class IncomingRegisterFixtures extends Fixture implements FixtureInterface, DependentFixtureInterface
{
    public const LOCATIONS = [
        'Marruecos',
        'Galicia',
        'Binefar',
        'Asturias',
        'Santander'
    ];

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
           SupplierFixtures::class,
           InTypesFixtures::class,
           ExplotationFixtures::class,
           RacesFixtures::class,
        ];
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $procedence = self::LOCATIONS[rand(0, count(self::LOCATIONS) - 1)];

            $supplier = $this->getReference(
                SupplierFixtures::SUPPLIERS[rand(0, count(SupplierFixtures::SUPPLIERS) - 1)]['companyName']
            );
            $inType = $this->getReference(
                InTypesFixtures::INTYPES[rand(0, count(InTypesFixtures::INTYPES) - 1)]['name']
            );

            $explotation = $this->getReference(
                ExplotationFixtures::NAMES_TEXT[rand(0, count(ExplotationFixtures::NAMES_TEXT) - 1)]
            );

            $race = $this->getReference(RacesFixtures::RACES[rand(0, count(RacesFixtures::RACES) - 1)]['code']);
            $registerUuid = Uuid::random()->getValue();
            $register = (new IncomingRegister())
                ->setProcedence($procedence)
                ->setUuid($registerUuid)
                ->setInType($inType)
                ->setSupplier($supplier)
                ->setExplotation($explotation)
                ->setCreatedBy(
                    $this->getReference(
                        UserFixtures::USERS[rand(0, count(UserFixtures::USERS) - 1)] ['username']
                    )
                );

            for ($j = 0; $j < rand(10,30); $j++) {
                $animal = new Animal();
                $crot = (string)rand(1000000000, 9999999999);
                $crotMother = (string)rand(1000000000, 9999999999);
                $num = substr($crot, -4);
                $date = new \DateTime();
                $date->modify('-' . rand(0, 500) . 'day');
                $genere = ($i%2 == 0)? 'Male':'Female';
                $animal
                    ->setInternalNum($num)
                    ->setCrotal($crot)
                    ->setCrotalMother($crotMother)
                    ->setWeightIn(rand(10, 20))
                    ->setIsIll(false)
                    ->setBirthDate($date)
                    ->setExplotation($explotation)
                    ->setGenre($genere)
                    ->setRace($race);

                $register->addAnimal($animal);
                $register->setAnimalsCount($register->getAnimalsCount() + 1);

                $animalRegisters = (new AnimalRegisters())
                    ->setCrotal($crot)
                    ->setIncomingRegisterUuid($registerUuid);

                $manager->persist($animalRegisters);
            }

            $manager->persist($register);
            $manager->flush();
        }

    }
}