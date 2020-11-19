<?php

namespace Mateu\Backend\Dashboard\Application\GetResumeBoxes;

use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Mateu\Backend\Purchaser\Domain\PurchaserRepositoryInterface;
use Mateu\Backend\Supplier\Domain\SupplierRepositoryInterface;
use Symfony\Component\Routing\RouterInterface;

class SummaryDashboardUseCase
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
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        AnimalRepositoryInterface $animalRepository,
        ExplotationRepositoryInterface $explotationRepository,
        SupplierRepositoryInterface $supplierRepository,
        PurchaserRepositoryInterface $purchaserRepository,
        RouterInterface $router
    ) {
        $this->animalRepository = $animalRepository;
        $this->explotationRepository = $explotationRepository;
        $this->supplierRepository = $supplierRepository;
        $this->purchaserRepository = $purchaserRepository;
        $this->router = $router;
    }

    public function execute()
    {
        $result = [
            'animals' => [
                'totals' => $this->animalRepository->getTotal(),
                'colorClass' => 'bg-aqua',
                'description' => 'Animales',
                'icon' => 'ion-bag',
                'link' => $this->router->generate('index_animals')
                ],
            'explotations' => [
                'totals' => $this->explotationRepository->getTotal(),
                'colorClass' => 'bg-red',
                'description' => 'Explotaciones',
                'icon' => 'ion-home',
                'link' => $this->router->generate('index_explotations')
            ],
            'suppliers' => [
                'totals' => $this->supplierRepository->getTotal(),
                'colorClass' => 'bg-yellow',
                'description' => 'Proveedores',
                'icon' => 'ion-ios-pulse-strong',
                'link' => null
            ],
            'Purchasers' => [
                'totals' => $this->purchaserRepository->getTotal(),
                'colorClass' => 'bg-green',
                'description' => 'Compradores',
                'icon' => 'ion-ios-pulse-strong',
                'link' => null
            ]
        ];

        return $result ;

    }

}