<?php

namespace Mateu\Backend\InType\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\InType\Domain\Entity\InType;
use Symfony\Bridge\Doctrine\RegistryInterface;

class InTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InType::class);
    }


}