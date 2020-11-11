<?php

namespace Mateu\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Mateu\Backend\User\Domain\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures  extends Fixture implements FixtureInterface
{
    public const USERS = [
        [
            'username' => 'alex_beis',
            'email' => 'superadmin@admin.com',
            'password' => 'sadmin123',
            'fullName' => 'Alex Beis',
            'roles' => [User::ROLE_SUPERADMIN]
        ],
        [
            'username' => 'rob_smith',
            'email' => 'admin@admin.com',
            'password' => 'admin123',
            'fullName' => 'Rob Smith',
            'roles' => [User::ROLE_ADMIN]
        ],
        [
            'username' => 'marry_gold',
            'email' => 'marry_gold@gold.com',
            'password' => 'marry12345',
            'fullName' => 'Marry Gold',
            'roles' => [User::ROLE_USER]
        ],
    ];

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (self::USERS as $userData) {

            $user = new User();
            $user->setFullName($userData['fullName']);
            $user->setEmail($userData['email']);
            $user->setUsername($userData['username']);
            $user->setPassword($this->userPasswordEncoder
                ->encodePassword(
                    $user,
                    $userData['password'])
            );
            $user->setRoles($userData['roles']);

            $this->addReference($userData['username'], $user);

            $manager->persist($user);
        }
        $manager->flush();

    }
}