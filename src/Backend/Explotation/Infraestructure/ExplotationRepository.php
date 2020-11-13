<?php

namespace Mateu\Backend\Explotation\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;


class ExplotationRepository extends ServiceEntityRepository implements ExplotationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Explotation::class);
    }

    public function save($explotation)
    {
        $this->_em->persist($explotation);

    }

    public function getTotal()
    {
        $qb = $this->createQueryBuilder('explotation');
        $qb->select('count(explotation.id)');
        $total = $qb->getQuery()->getSingleScalarResult();

        return $total;
    }

    public function remove($explotation)
    {
        $this->_em->remove($explotation);

    }

    public function getExplotationWithAnimals($id)
    {
        $qb = $this->createQueryBuilder('explotation');
        $query =
            $qb
                ->where('explotation.id = :id')
                ->setParameters(['id' => $id])
                ->getQuery();

        return $query->getOneOrNullResult();

    }


    // /**
    //  * @return Explotation[] Returns an array of Explotation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Explotation
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
