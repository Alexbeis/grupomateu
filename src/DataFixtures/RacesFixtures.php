<?php

namespace Mateu\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mateu\Backend\Race\Domain\Entity\Race;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;

class RacesFixtures extends Fixture implements FixtureInterface
{
    public const RACES = [
        ['code' => '0001', 'name' => 'raza1'],
        ['code' => '0002', 'name' => 'raza2'],
        ['code' => '0003', 'name' => 'raza3']
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::RACES as $key => $race) {
            $r = new Race(Uuid::random()->getValue(),$race['code'], $race['name']);
            $this->addReference($race['code'], $r);

            $manager->persist($r);
        }
        $manager->flush();
    }
}