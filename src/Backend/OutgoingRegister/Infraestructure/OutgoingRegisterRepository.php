<?php

namespace Mateu\Backend\OutgoingRegister\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Mateu\Backend\OutgoingRegister\Domain\Entity\OutgoingRegister;
use Mateu\Backend\OutgoingRegister\Domain\OutgoingRegisterRepositoryInterface;

class OutgoingRegisterRepository extends ServiceEntityRepository implements OutgoingRegisterRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OutgoingRegister::class);
    }

}