<?php

namespace Mateu\Backend\Transporter\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\Transporter\Domain\Entity\Transporter;

class DoctrineTransporterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transporter::class);
    }

}