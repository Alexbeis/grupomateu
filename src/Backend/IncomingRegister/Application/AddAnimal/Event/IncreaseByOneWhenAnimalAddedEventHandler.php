<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal\Event;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\IncomingRegister\Application\AddAnimal\IncomingRegisterAnimalAdded;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class IncreaseByOneWhenAnimalAddedEventHandler implements MessageHandlerInterface
{
    /**
     * @var IncomingRegisterRepositoryInterface
     */
    private $incomingRegisterRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        IncomingRegisterRepositoryInterface $incomingRegisterRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->incomingRegisterRepository = $incomingRegisterRepository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(IncomingRegisterAnimalAdded $event)
    {
        /**
         * @var IncomingRegister $incomingRegister
         */
        $incomingRegister = $this->incomingRegisterRepository->findOneById($event->getIncomingRegisterId());
        $incomingRegister
            ->setAnimalsCount($incomingRegister->getAnimalsCount() + 1);

        $this->entityManager->flush();
    }
}