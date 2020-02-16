<?php

namespace Mateu\Backend\Animal\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;
use Mateu\Backend\Animal\Domain\Entity\Animal;


/**
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository implements AnimalRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function existsByCrotalNum($crotalNum)
    {
        return null !== $this->findOneByCrotal($crotalNum);

    }

    public function save(Animal $animal)
    {
        $this->_em->persist($animal);
    }

    public function getTotal()
    {
        $qb = $this->createQueryBuilder('animal');
        $qb
            ->select('count(animal.id)')
            ->andWhere('animal.outgoingRegister IS NULL');
        $total = $qb->getQuery()->getSingleScalarResult();

        return $total;
    }

    public function computeTotalsPerExplotation()
    {
        $qb = $this->createQueryBuilder('animal');
        $qb->select('exp.name', 'exp.code', 'count(animal.id) as total')
            ->join('animal.explotation', 'exp')
            ->andWhere('animal.outgoingRegister IS NULL')
            ->groupBy('exp.id')
            ->orderBy('count(animal.id)','DESC');

        $result = $qb->getQuery()->getArrayResult();

        return $result;
    }

    public function computeTotalsPerRace()
    {
        $qb = $this->createQueryBuilder('animal');
        $qb->select('race.name', 'count(animal.id) as total')
            ->join('animal.race', 'race')
            ->groupBy('race.id')
            ->orderBy('count(animal.id)','DESC');
        $result = $qb->getQuery()->getArrayResult();

        return $result;
    }
}