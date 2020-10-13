<?php

namespace Mateu\Backend\Movement\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\Movement\Domain\Entity\Movement;

class MovementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movement::class);
    }

    public function save(Movement $movement)
    {
        $this->_em->persist($movement);
    }

}