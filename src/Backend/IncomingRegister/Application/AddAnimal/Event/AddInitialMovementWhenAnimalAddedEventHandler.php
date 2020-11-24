<?php

namespace Mateu\Backend\IncomingRegister\Application\AddAnimal\Event;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Domain\Entity\Animal;
use Mateu\Backend\Animal\Infraestructure\AnimalRepository;
use Mateu\Backend\IncomingRegister\Application\AddAnimal\IncomingRegisterAnimalAdded;
use Mateu\Backend\Movement\Domain\Entity\Movement;
use Mateu\Backend\Movement\Infraestructure\MovementRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Security\Core\Security;

class AddInitialMovementWhenAnimalAddedEventHandler implements MessageHandlerInterface
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
     * @var AnimalRepository
     */
    private $animalRepository;
    /**
     * @var Security
     */
    private $security;

    public function __construct(
        MovementRepository $movementRepository,
        AnimalRepository $animalRepository,
        Security $security,
        EntityManagerInterface $entityManager
    ) {
        $this->movementRepository = $movementRepository;
        $this->entityManager = $entityManager;
        $this->animalRepository = $animalRepository;
        $this->security = $security;
    }

    public function __invoke(IncomingRegisterAnimalAdded $animalAdded)
    {
        /**
         * @var Animal $animal
         */
        $animal = $this->animalRepository->find($animalAdded->getAnimalId());

        $movement = Movement::fromIncomingRegister(
            $animalAdded->getOldExplotationCode()?:'-',
            $animalAdded->getNewExplotationCode(),
            $animal,
            $this->security->getUser()
        );

        $this->movementRepository->save($movement);

        $this->entityManager->flush();
    }
}
