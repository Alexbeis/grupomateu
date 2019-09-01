<?php

namespace Mateu\Backend\Animal\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Symfony\Bridge\Doctrine\RegistryInterface;


/**
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository implements AnimalRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    public function save()
    {
        // TODO: Implement save() method.
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