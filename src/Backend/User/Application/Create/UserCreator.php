<?php

namespace Mateu\Backend\User\Application\Create;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\User\Domain\Entity\User;
use Mateu\Backend\User\Infraestructure\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCreator
{
    private $userRepository;
    private $entityManager;
    private $passwordEncoder;

    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function create($email, $username, $fullname, $password)
    {
        $user = new User();
        $user
            ->setUsername($username)
            ->setFullName($fullname)
            ->setEmail($email)
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->passwordEncoder
                    ->encodePassword(
                        $user,
                        $password
                    )
            );

        $this->userRepository->save($user);
        $this->entityManager->flush();
    }
}