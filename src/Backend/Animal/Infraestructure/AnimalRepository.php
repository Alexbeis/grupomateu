<?php

namespace Mateu\Backend\Animal\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;
use Mateu\Backend\Animal\Domain\CrotalNum;
use Mateu\Backend\Animal\Domain\Entity\Animal;

class AnimalRepository extends ServiceEntityRepository implements AnimalRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function existsByCrotalNum(CrotalNum $crotalNum)
    {
        return null !== $this->findOneByCrotal($crotalNum->value());

    }

    public function save(Animal $animal)
    {
        $this->_em->persist($animal);
    }

    public function getTotal()
    {
        $qb = $this->createQueryBuilder('animal');
        $qb->select('count(animal.id)');
        $total = $qb->getQuery()->getSingleScalarResult();

        return $total;
    }

    public function computeTotalsPerExplotation()
    {
        $qb = $this->createQueryBuilder('animal');
        $qb->select('exp.name', 'exp.code', 'count(animal.id) as total')
            ->join('animal.explotation', 'exp')
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