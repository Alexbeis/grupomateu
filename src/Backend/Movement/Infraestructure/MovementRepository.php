<?php

namespace Mateu\Backend\Movement\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\Movement\Domain\Entity\Movement;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MovementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Movement::class);
    }

    public function save(Movement $movement)
    {
        $this->_em->persist($movement);
    }

}