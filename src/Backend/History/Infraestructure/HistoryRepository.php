<?php

namespace Mateu\Backend\History\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\History\Domain\Entity\History;

class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function save($history)
    {
        $this->_em->persist($history);
    }

}
