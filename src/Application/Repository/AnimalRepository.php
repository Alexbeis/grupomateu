<?php

namespace App\Application\Repository;
use App\Domain\AnimalRepositoryInterface;
use App\Domain\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
}