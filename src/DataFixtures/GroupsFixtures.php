<?php

namespace Mateu\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mateu\Backend\Group\Domain\Entity\Group;

class GroupsFixtures extends Fixture implements FixtureInterface
{
    public const GROUPS = [
        ['code' => 'G001', 'name' => 'Grupo1'],
        ['code' => 'G002', 'name' => 'Grupo2'],
        ['code' => 'G003', 'name' => 'Grupo3']
    ];

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::GROUPS as $group) {
            $g = Group::create($group['code'], $group['name']);
            $this->addReference($group['name'], $g);

            $manager->persist($g);
        }

        $manager->flush();
    }
}