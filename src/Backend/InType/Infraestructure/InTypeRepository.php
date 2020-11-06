<?php

namespace Mateu\Backend\InType\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\InType\Domain\Entity\InType;

class InTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InType::class);
    }

    public function save(InType $inType)
    {
        $this->_em->persist($inType);
    }


}