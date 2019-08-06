<?php

namespace Mateu\Backend\Race\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Mateu\Backend\Race\Domain\Entity\Race;
use Mateu\Backend\Race\Domain\RaceRepositoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Race|null find($id, $lockMode = null, $lockVersion = null)
 * @method Race|null findOneBy(array $criteria, array $orderBy = null)
 * @method Race[]    findAll()
 * @method Race[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RaceRepository extends ServiceEntityRepository implements RaceRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Race::class);
    }

    public function save(Race $race)
    {
        $this->_em->persist($race);
    }

    public function getAll()
    {
        return $this->findAll();
    }

    public function delete(Race $race)
    {
        $this->_em->remove($race);
    }

    public function exist($id)
    {
        return $this->createQueryBuilder('r')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult() !== null;
    }


    // /**
    //  * @return Race[] Returns an array of Race objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Race
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
