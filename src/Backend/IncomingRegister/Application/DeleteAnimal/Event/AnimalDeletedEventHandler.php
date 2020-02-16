<?php

namespace Mateu\Backend\IncomingRegister\Application\DeleteAnimal\Event;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\IncomingRegister\Application\DeleteAnimal\AnimalDeleted;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;

class AnimalDeletedEventHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var IncomingRegisterRepositoryInterface
     */
    private $incomingRegisterRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        IncomingRegisterRepositoryInterface $incomingRegisterRepository
    ) {

        $this->entityManager = $entityManager;
        $this->incomingRegisterRepository = $incomingRegisterRepository;
    }

    public function __invoke(AnimalDeleted $animalDeleted)
    {
        /**
         * @var IncomingRegister $incomingRegister
         */
        $incomingRegister = $this->incomingRegisterRepository->findOneById($animalDeleted->getIncRegisterId());
        $incomingRegister
            ->setAnimalsCount(
                $incomingRegister->getAnimalsCount() - 1
            );

        $this->entityManager->flush();
    }
}