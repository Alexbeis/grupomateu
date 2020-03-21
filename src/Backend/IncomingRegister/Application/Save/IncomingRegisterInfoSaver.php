<?php

namespace Mateu\Backend\IncomingRegister\Application\Save;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Explotation\Domain\ExplotationNotFound;
use Mateu\Backend\Explotation\Domain\ExplotationRepositoryInterface;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterNotFound;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;
use Mateu\Backend\InType\Domain\InTypeNotFound;
use Mateu\Backend\InType\Infraestructure\InTypeRepository;
use Mateu\Backend\Supplier\Domain\SupplierRepositoryInterface;
use Mateu\Shared\Domain\Countries\Countries;

final class IncomingRegisterInfoSaver
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var IncomingRegisterRepositoryInterface
     */
    private $incomingRegisterRepository;
    /**
     * @var Countries
     */
    private $countries;
    /**
     * @var ExplotationRepositoryInterface
     */
    private $explotationRepository;
    /**
     * @var SupplierRepositoryInterface
     */
    private $supplierRepository;
    /**
     * @var InTypeRepository
     */
    private $inTypeRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        IncomingRegisterRepositoryInterface $incomingRegisterRepository,
        Countries $countries,
        ExplotationRepositoryInterface $explotationRepository,
        SupplierRepositoryInterface $supplierRepository,
        InTypeRepository $inTypeRepository
    ) {
        $this->entityManager = $entityManager;
        $this->incomingRegisterRepository = $incomingRegisterRepository;
        $this->countries = $countries;
        $this->explotationRepository = $explotationRepository;
        $this->supplierRepository = $supplierRepository;
        $this->inTypeRepository = $inTypeRepository;
    }

    public function execute(
        int $id,
        int $explotationId,
        string $procedenceCode,
        int $inTypeId,
        int $supplierId,
        $guideNum,
        $guideDate,
        $origin
    ) {
        if (!$incomingRegister = $this->incomingRegisterRepository->findOneById($id)) {
            throw new IncomingRegisterNotFound('Registro no encontrado');
        }

        if (!$explotation = $this->explotationRepository->findOneById($explotationId)) {
            throw new ExplotationNotFound('Explotación no encontrada');
        }

        if (!array_key_exists($procedenceCode, $this->countries->getList())) {
            throw new \InvalidArgumentException('Pais inválido');
        } else {
            $country = $this->countries->getList()[$procedenceCode];
        }

        if (!$inType = $this->inTypeRepository->findOneById($inTypeId)) {
            throw new InTypeNotFound('Tipo de Entrada no encontrado');
        }

        if (!$supplier = $this->supplierRepository->findOneById($supplierId)) {
            throw new \Exception('Supplier not found');
        }

        /**
         * @var IncomingRegister $incomingRegister
         */
        $incomingRegister
            ->setExplotation($explotation)
            ->setProcedence($country)
            ->setInType($inType)
            ->setSupplier($supplier)
            ->setGuideNum($guideNum)
            ->setGuideDate(new DateTime($guideDate))
            ->setOriginExplotation($origin);

        $this->entityManager->flush();
    }
}