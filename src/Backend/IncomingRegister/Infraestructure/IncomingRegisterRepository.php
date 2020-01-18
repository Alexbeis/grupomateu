<?php

namespace Mateu\Backend\IncomingRegister\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;

use Symfony\Bridge\Doctrine\RegistryInterface;

class IncomingRegisterRepository extends ServiceEntityRepository implements IncomingRegisterRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, IncomingRegister::class);
    }
}
