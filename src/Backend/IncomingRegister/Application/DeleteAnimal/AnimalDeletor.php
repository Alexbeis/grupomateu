<?php

namespace Mateu\Backend\IncomingRegister\Application\DeleteAnimal;

use Doctrine\ORM\EntityManagerInterface;
use Mateu\Backend\Animal\Domain\AnimalNotFound;
use Mateu\Backend\Animal\Domain\AnimalRepositoryInterface;
use Mateu\Backend\IncomingRegister\Domain\Entity\IncomingRegister;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterNotFound;
use Mateu\Backend\IncomingRegister\Domain\IncomingRegisterRepositoryInterface;
use Mateu\Shared\Domain\ValueObject\GenericId;
use Symfony\Component\Messenger\MessageBusInterface;

final class AnimalDeletor
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
     * @var AnimalRepositoryInterface
     */
    private $animalRepository;
    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    public function __construct(
        EntityManagerInterface $entityManager,
        IncomingRegisterRepositoryInterface $incomingRegisterRepository,
        AnimalRepositoryInterface $animalRepository,
        MessageBusInterface $eventBus
    ) {
        $this->entityManager = $entityManager;
        $this->incomingRegisterRepository = $incomingRegisterRepository;
        $this->animalRepository = $animalRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * Here we are removing the relation from register and animal. Animal itself shouldn't be removed from DB
     * We are also leaving the animal without explotation.
     * @param GenericId $incRegisterId
     * @param GenericId $animalId
     *
     * @throws AnimalNotFound
     * @throws IncomingRegisterNotFound
     */
    public function delete(GenericId $incRegisterId,  GenericId $animalId)
    {
        /**
         * @var IncomingRegister $incomingRegister
         */
        if (!$incomingRegister = $this->incomingRegisterRepository->findOneById($incRegisterId->value())) {
            throw new IncomingRegisterNotFound('Registro de entrada no encontrado');
        }

        /**
         * @var IncomingRegister $incomingRegister
         */
        if (!$animal = $this->animalRepository->findOneById($animalId->value())) {
            throw new AnimalNotFound();
        }
        $animal->setExplotation(null);
        $incomingRegister->removeAnimal($animal);

        $this->entityManager->flush();

        $this->eventBus->dispatch(
            new AnimalDeleted($incRegisterId->value()
            )
        );
    }
}