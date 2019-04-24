<?php

namespace App\Application\Repository;

use App\Domain\Entity\Explotation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Explotation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Explotation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Explotation[]    findAll()
 * @method Explotation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExplotationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Explotation::class);
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
