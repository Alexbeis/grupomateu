<?php

namespace Mateu\Backend\History\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\History\Domain\Entity\History;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method History|null find($id, $lockMode = null, $lockVersion = null)
 * @method History|null findOneBy(array $criteria, array $orderBy = null)
 * @method History[]    findAll()
 * @method History[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, History::class);
    }

    public function save($history)
    {
        $this->_em->persist($history);
    }

}
