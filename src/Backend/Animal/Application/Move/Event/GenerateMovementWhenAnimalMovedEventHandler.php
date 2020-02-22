<?php

namespace Mateu\Backend\Animal\Application\Move\Event;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Application\Find\AnimalFinder;
use Mateu\Backend\Animal\Application\Move\AnimalMoved;
use Mateu\Backend\Movement\Domain\Entity\Movement;
use Mateu\Backend\Movement\Infraestructure\MovementRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Security\Core\Security;

class GenerateMovementWhenAnimalMovedEventHandler implements MessageHandlerInterface
{
    /**
     * @var MovementRepository
     */
    private $movementRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var Security
     */
    private $security;
    /**
     * @var AnimalFinder
     */
    private $animalFinder;

    public function __construct(
        MovementRepository $movementRepository,
        AnimalFinder $animalFinder,
        EntityManagerInterface $entityManager,
        Security $security
    ) {
        $this->movementRepository = $movementRepository;
        $this->animalFinder = $animalFinder;
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    public function __invoke(AnimalMoved $event)
    {
        $animal= $this->animalFinder->find($event->getAnimalId());
        $movement = Movement::createStandard(
            $event->getFrom(),
            $event->getTo(),
            $animal,
            $this->security->getToken()->getUser()
        );

        $this->movementRepository->save($movement);
        $this->entityManager->flush();
    }

}