<?php

namespace Mateu\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;

class ExplotationFixtures extends Fixture implements FixtureInterface, DependentFixtureInterface
{
    public const NAMES_TEXT = [
        'Julia Trillo',
        'Gloria Trillo',
        'Ana 1',
        'Ana 2',
        'Mateu 1',
        'Berta',
        'Loles',
        'Aloha',
        'Angel'
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
            UserFixtures::class,
            GroupsFixtures::class
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
        foreach (self::NAMES_TEXT as $key => $explotation) {
            $e = new Explotation();
            $e
                ->setCode('EXPL_' . $key)
                ->setLocalization(uniqid('LOC_'))
                ->setName($explotation)
                ->setCreatedBy(
                $this->getReference(
                    UserFixtures::USERS[rand(0, count(UserFixtures::USERS) - 1)] ['username']
                )
            );
            $date = (new \DateTime())->modify('-' . rand(0, 10) . 'day');
            $e
                ->setCreatedAt($date)
                ->setGroup(
                    $this->getReference(
                        GroupsFixtures::GROUPS[rand(0, count(GroupsFixtures::GROUPS) - 1)]['name']
                    )
                );

            $this->addReference($explotation, $e);

            $manager->persist($e);
        }

        $manager->flush();
    }
}