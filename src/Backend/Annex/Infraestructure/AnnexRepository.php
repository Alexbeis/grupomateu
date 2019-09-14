<?php

namespace Mateu\Backend\Annex\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\Annex\Domain\AnnexRepositoryInterface;
use Mateu\Backend\Annex\Domain\Entity\Annex;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AnnexRepository extends ServiceEntityRepository implements AnnexRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Annex::class);
    }

    public function save(Annex $annex)
    {
        $this->_em->persist($annex);
    }

    public function getTotals()
    {
        $qb = $this->createQueryBuilder('annex');
        $qb->select('count(annex.id)');
        $total = $qb->getQuery()->getSingleScalarResult();

        return $total;
    }

    public function exists(string $crotal)
    {
        return null !== $this->findByAnimalCrotal($crotal);
    }

    public function remove($annex)
    {
        $this->_em->remove($annex);
    }
}