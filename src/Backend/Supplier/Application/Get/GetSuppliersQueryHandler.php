<?php

namespace Mateu\Backend\Supplier\Application\Get;

use Mateu\Backend\Supplier\Domain\SupplierRepositoryInterface;

class GetSuppliersQueryHandler
{
    /**
     * @var SupplierRepositoryInterface
     */
    private $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function __invoke(GetSuppliersQuery $suppliersQuery)
    {
        return $this->supplierRepository->findAll();
    }
}