<?php

namespace App\Application\Repository;

use App\Domain\Entity\Supplier;
use App\Domain\SupplierRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Supplier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supplier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supplier[]    findAll()
 * @method Supplier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplierRepository extends ServiceEntityRepository implements SupplierRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

    public function save()
    {
        // TODO: Implement save() method.
    }

    public function getTotal()
    {
        $qb = $this->createQueryBuilder('supplier');
        $qb->select('count(supplier.id)');
        $total = $qb->getQuery()->getSingleScalarResult();

        return $total;
    }
}
