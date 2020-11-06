<?php

namespace Mateu\Backend\Supplier\Infraestructure;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Mateu\Backend\Supplier\Domain\Entity\Supplier;
use Mateu\Backend\Supplier\Domain\SupplierRepositoryInterface;

class SupplierRepository extends ServiceEntityRepository implements SupplierRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
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
