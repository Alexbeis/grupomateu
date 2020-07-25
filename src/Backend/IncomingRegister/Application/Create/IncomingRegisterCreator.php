<?php

namespace Mateu\Backend\IncomingRegister\Application\Create;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Application\Find\ExplotationFinder;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;
use Mateu\Backend\InType\Domain\InTypeNotFound;
use Mateu\Backend\InType\Infraestructure\InTypeRepository;
use Mateu\Backend\Supplier\Infraestructure\SupplierRepository;
use Mateu\Shared\Domain\Countries\Countries;
use Symfony\Component\Security\Core\Security;

final class IncomingRegisterCreator
{
    /**
     * @var IncomingRegisterRepositoryInterface
     */
    private $incomingRegisterRepository;
    /**
     * @var InTypeRepository
     */
    private $inTypeRepository;
    /**
     * @var ExplotationFinder
     */
    private $explotationFinder;
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;
    /**
     * @var Countries
     */
    private $countries;
    /**
     * @var SupplierRepository
     */
    private $supplierRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Security
     */
    private $security;

    public function __construct(
        IncomingRegisterRepositoryInterface $incomingRegisterRepository,
        InTypeRepository $inTypeRepository,
        ExplotationFinder $explotationFinder,
        ExplotationRepositoryInterface $explotationRepository,
        SupplierRepository $supplierRepository,
        EntityManagerInterface $entityManager,
        Security $security,
        Countries $countries

    ) {
        $this->incomingRegisterRepository = $incomingRegisterRepository;
        $this->inTypeRepository = $inTypeRepository;
        $this->explotationFinder = $explotationFinder;
        $this->explotationRepository = $explotationRepository;
        $this->countries = $countries;
        $this->supplierRepository = $supplierRepository;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function create($uuid, $inTypeId, $procedenceId, $exploId, $supplierId, $guideNum, $guideDate, $origin)
    {
        // Validate
        if (!$intype = $this->inTypeRepository->findOneBy(['id' => $inTypeId])) {
            throw new InTypeNotFound(sprintf('Tipo de entrada (%d) no encontrado', $inTypeId));
        }

        if (!array_key_exists($procedenceId, $this->countries->getList())) {
            throw new \Exception('fail procedence');
        } else {
            $procedence = $this->countries->getList()[$procedenceId];
        }

        $explotation = $this->explotationFinder->__invoke($exploId);

        $supplier = $this->supplierRepository->findOneBy(['id' => $supplierId]);

        $user = $this->security->getUser();

        $guideNum = !empty($guideNum) ? $guideNum : null;
        $guideDate = !empty($guideDate) ? new DateTime($guideDate) : null;
        $origin = !empty($origin) ? $origin : null;

        // Instantiate
        $incomingRegister = IncomingRegister::fromPhaseOne(
            $uuid,
            $intype,
            $explotation,
            $procedence,
            $supplier,
            $guideNum,
            $guideDate,
            $origin,
            $user
        );

        $this->incomingRegisterRepository->save($incomingRegister);

        $this->entityManager->flush();
    }
}