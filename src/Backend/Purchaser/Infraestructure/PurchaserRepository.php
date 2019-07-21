<?php

namespace Mateu\Backend\Purchaser\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\Purchaser\Domain\Entity\Purchaser;
use Mateu\Backend\Purchaser\Domain\PurchaserRepositoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Purchaser|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchaser|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchaser[]    findAll()
 * @method Purchaser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaserRepository extends ServiceEntityRepository implements PurchaserRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
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
