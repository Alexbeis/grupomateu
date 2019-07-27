<?php

namespace Mateu\Backend\OutType\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\OutType\Domain\Entity\OutType;
use Symfony\Bridge\Doctrine\RegistryInterface;

class OutTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OutType::class);
    }
}