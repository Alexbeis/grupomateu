<?php

namespace Mateu\Backend\Register\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\Register\Domain\Entity\Register;
use Mateu\Backend\Register\Domain\RegisterRepositoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RegisterRepository extends ServiceEntityRepository implements RegisterRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Register::class);
    }
}
