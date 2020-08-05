<?php

namespace Mateu\Backend\AnimalRegisters\Application\Create;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\AnimalRegisters\Domain\AnimalRegistersInterface;
use Mateu\Backend\AnimalRegisters\Domain\Entity\AnimalRegisters;

class AnimalRegisterCreator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var AnimalRegistersInterface
     */
    private $animalRegisters;

    public function __construct(EntityManagerInterface $entityManager, AnimalRegistersInterface $animalRegisters)
    {
        $this->entityManager = $entityManager;
        $this->animalRegisters = $animalRegisters;
    }

    public function create(string $crotalNum, string $incomingRegisterUuid)
    {
        $animalRegister = (new AnimalRegisters())
            ->setCrotal($crotalNum)
            ->setIncomingRegisterUuid($incomingRegisterUuid);

        $this->animalRegisters->persist($animalRegister);
        $this->entityManager->flush();
    }
}