<?php

namespace Mateu\Backend\OutgoingRegister\Application\Save;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\OutgoingRegister\Domain\Entity\OutgoingRegister;
use Mateu\Backend\OutgoingRegister\Domain\OutgoingRegisterRepositoryInterface;
use Mateu\Backend\OutType\Domain\Entity\OutType;

final class OutGoingRegisterSaver
{
    private $outgoingRegisterRepository;

    private $entityManager;

    public function __construct(
        OutgoingRegisterRepositoryInterface $outgoingRegisterRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->outgoingRegisterRepository = $outgoingRegisterRepository;
        $this->entityManager = $entityManager;
    }

    public function save($data)
    {
        /**
         * @var OutgoingRegister $outgoingRegister
         */
        $outgoingRegister = $this->outgoingRegisterRepository->findOneById($data['out_reg_id']);
        if (!$outgoingRegister) {
            throw new \Exception('Registro de Salida no encontrado');
        }

        $outgoingRegister
            ->setDestination($data['out_reg_dest'])
            //->setPurchaser($data['out_reg_purchaser'])
            ->setOutGuide($data['out_reg_guide_num'])
            ->setOutDate(new \DateTime($data['out_reg_guide_date']))
            ->setOutType($this->entityManager->getReference(OutType::class, $data['out_reg_type']));

        $this->entityManager->flush();
    }
}