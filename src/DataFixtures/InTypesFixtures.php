<?php

namespace Mateu\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mateu\Backend\InType\Domain\Entity\InType;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;

class InTypesFixtures extends Fixture implements FixtureInterface
{
    public const INTYPES = [
        ['code' => '001', 'name' => 'Nacimiento'],
        ['code' => '002', 'name' => 'Compra'],
        ['code' => '003', 'name' => 'Translado'],
        ['code' => '004', 'name' => 'Otro']
    ];
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::INTYPES as $inType) {
            $t = InType::create(Uuid::random()->getValue(), $inType['code'], $inType['name']);
            $this->addReference($inType['name'], $t);

            $manager->persist($t);
        }

        $manager->flush();
    }
}