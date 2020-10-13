<?php

namespace Mateu\Backend\Purchaser\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\Purchaser\Domain\Entity\Purchaser;
use Mateu\Backend\Purchaser\Domain\PurchaserRepositoryInterface;

class PurchaserRepository extends ServiceEntityRepository implements PurchaserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchaser::class);
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function getTotal()
    {
        $qb = $this->createQueryBuilder('purchaser');
        $qb->select('count(purchaser.id)');
        $total = $qb->getQuery()->getSingleScalarResult();

        return $total;
    }

    // /**
    //  * @return Purchaser[] Returns an array of Purchaser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Purchaser
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
