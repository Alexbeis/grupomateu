<?php

namespace Mateu\Backend\Explotation\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\Explotation\Domain\Entity\Explotation;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Explotation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Explotation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Explotation[]    findAll()
 * @method Explotation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExplotationRepository extends ServiceEntityRepository implements ExplotationRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
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
                ->join('Mateu\Backend\Animal\Domain\Entity\Animal', 'animal')
                ->join('Mateu\Backend\Group\Domain\Entity\Group', 'group')
                ->where('explotation.id = :id')
                ->andWhere('animal.outgoingRegister IS NULL')
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
