<?php

namespace Mateu\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mateu\Backend\OutType\Domain\Entity\OutType;
use Mateu\Backend\OutType\Domain\OutTypeCode;
use Mateu\Shared\Domain\ValueObject\Uuid\Uuid;

class OutTypesFixtures extends Fixture implements FixtureInterface
{
    public const OUTTYPES = [
        ['code' => '001', 'name' => 'Venta'],
        ['code' => '002', 'name' => 'Muerte'],
        ['code' => '003', 'name' => 'Otros']
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::OUTTYPES as $outtype) {
            $ot = OutType::create(
                Uuid::random()->getValue(),
                new OutTypeCode($outtype['code']),
                $outtype['name']
            );
            $this->addReference($outtype['name'], $ot);

            $manager->persist($ot);
        }

        $manager->flush();
    }
}