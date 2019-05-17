<?php

namespace App\Domain\UseCases\Dashboard;

use App\Domain\AnimalRepositoryInterface;
use App\Domain\ExplotationRepositoryInterface;
use App\Domain\PurchaserRepositoryInterface;
use App\Domain\SupplierRepositoryInterface;

class SummaryDashboard
{
    /**
     * @var AnimalRepositoryInterface
     */
    private $animalRepository;
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;
    /**
     * @var SupplierRepositoryInterface
     */
    private $supplierRepository;
    /**
     * @var PurchaserRepositoryInterface
     */
    private $purchaserRepository;

    public function __construct(AnimalRepositoryInterface $animalRepository,
                                ExplotationRepositoryInterface $explotationRepository,
                                SupplierRepositoryInterface $supplierRepository,
                                PurchaserRepositoryInterface $purchaserRepository
                                )
    {
        $this->animalRepository = $animalRepository;
        $this->explotationRepository = $explotationRepository;
        $this->supplierRepository = $supplierRepository;
        $this->purchaserRepository = $purchaserRepository;
    }

    public function execute()
    {
        $result = [
            'animals' => [
                'totals' => $this->animalRepository->getTotal(),
                'colorClass' => 'bg-aqua',
                'description' => 'Animals',
                'icon' => 'ion-bag'
                ],
            'explotations' => [
                'totals' => $this->explotationRepository->getTotal(),
                'colorClass' => 'bg-red',
                'description' => 'Explotations',
                'icon' => 'ion-home'
            ],
            'suppliers' => [
                'totals' => $this->supplierRepository->getTotal(),
                'colorClass' => 'bg-yellow',
                'description' => 'Suppliers',
                'icon' => 'ion-ios-pulse-strong'
            ],
            'Purchasers' => [
                'totals' => $this->purchaserRepository->getTotal(),
                'colorClass' => 'bg-green',
                'description' => 'Purchasers',
                'icon' => 'ion-ios-pulse-strong'
            ]
        ];

        return $result ;

    }

}